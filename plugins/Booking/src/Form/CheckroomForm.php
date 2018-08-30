<?php

namespace Booking\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Settings\Utility\Setting;

/**
 * Checkroom Form.
 */
class CheckroomForm extends Form {

    /**
     * Builds the schema for the modelless form
     *
     * @param Schema $schema From schema
     * @return $this
     */
    protected function _buildSchema(Schema $schema) {
        return $schema->addField('content_id', ['type' => 'integer'])
                        ->addField('checkin', 'string')
                        ->addField('checkout', ['type' => 'string'])
                        ->addField('adults', ['type' => 'integer'])
                        ->addField('children', ['type' => 'integer'])
                        ->addField('first_name', ['type' => 'string'])
                        ->addField('last_name', ['type' => 'string'])
                        ->addField('email', ['type' => 'string'])
                        ->addField('phone', ['type' => 'string']);
    }

    /**
     * Form validation builder
     *
     * @param Validator $validator to use against the form
     * @return Validator
     */
    protected function _buildValidator(Validator $validator) {
        $validator->add('content_id', 'valid', ['rule' => 'numeric'])
                ->notEmpty('checkin')
                ->notEmpty('checkout')
                ->add('adults', 'valid', ['rule' => 'numeric'])
                ->add('children', 'valid', ['rule' => 'numeric'])
                ->notEmpty('first_name')
                ->notEmpty('last_name')
                ->add('email', 'valid', ['rule' => 'email'])
                ->notEmpty('phone');
        return $validator;
    }

    /**
     * Defines what to execute once the From is being processed
     *
     * @return bool
     */
    protected function _execute(array $data) {
        $this->Bookings = TableRegistry::get('Booking.Bookings');
        $booking = $this->Bookings->newEntity($data);
        if ($this->Bookings->saveNetwork($booking)) {
            $this->Contents = TableRegistry::get('Contents.Contents');
            $content = $this->Contents->find()
                    ->find('network')
                    ->select(['Contents.id', 'Contents.name', 'Contents.slug'])
                    ->contain(['ContentMetas' => function($q) {
                            return $q->select(['id', 'key', 'value', 'content_id']);
                        }])
                    ->where(['Contents.id' => $data['content_id'], 'Contents.status' => 1, 'Contents.delete' => 0])
                    ->first();

            $setting = new Setting();
            $email = new Email('default');
            $email->to([$data['email'], $setting->getOption('Sites.admin_email')])
                    ->helpers(['Ittvn.Layout'])
                    ->emailFormat('html')
                    ->viewVars(['booking' => $data, 'content' => $content])
                    ->template('Booking.check')
                    ->subject(sprintf(__d('ittvn', '%s checking room type: %s.'), $data['first_name'] . ' ' . $data['last_name'], $content->name))
                    ->send();

            return true;
        }
        return false;
    }

}
