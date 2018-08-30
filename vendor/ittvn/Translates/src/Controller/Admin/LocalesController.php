<?php

namespace Translates\Controller\Admin;

use Translates\Controller\AppController;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Utility\Inflector;
use Cake\Utility\Hash;
use Cake\Cache\Cache;

/**
 * Locales Controller
 *
 * @property \Translates\Model\Table\LocalesTable $Locales
 */
class LocalesController extends AppController {

    /**
     * Paths to use when looking for strings
     *
     * @var array
     */
    protected $_paths = [];

    /**
     * Files from where to extract
     *
     * @var array
     */
    protected $_files = [];

    /**
     * Current file being processed
     *
     * @var string
     */
    protected $_file = null;

    /**
     * Extracted tokens
     *
     * @var array
     */
    protected $_tokens = [];

    /**
     * Extracted strings indexed by domain.
     *
     * @var array
     */
    protected $_translations = [];
    protected $_errors = [];

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {

        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Locales');
            unset($tableParams['trash']);
            //pr($tableParams);die();
            if (count($tableParams['search']) > 0) {
                $query = $this->Locales->find('search', $this->Locales->filterParams($tableParams['search']));
            } else {
                $query = $this->Locales->find();
            }
            $query->select(['Locales.id', 'Locales.msgid', 'Locales.domain'])->contain(['Translates']);
            $this->DataTable->no_action = true;
            $this->DataTable->no_checkbox = true;
            $this->DataTable->table('Locales', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Locale id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $locale = $this->Locales->get($id, [
            'contain' => ['Translates']
        ]);
        $this->set('locale', $locale);
        $this->set('_serialize', ['locale']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $locale = $this->Locales->newEntity();
        if ($this->request->is('post')) {
            $return = ['status'=>false,'data'=>''];
            $languages = $this->request->data['language_id'];
            unset($this->request->data['language_id']);
            $locale = $this->Locales->patchEntity($locale, $this->request->data);
            if ($this->Locales->save($locale)) {
                $this->loadModel('Extensions.Translates');
                foreach ($languages as $language => $msgstr){
                    $translate = $this->Translates->newEntity([
                        'language_id' => $language,
                        'locale_id' => $locale->id,
                        'msgstr' => $msgstr
                    ]);
                    $this->Translates->save($translate);
                }
                $return['status'] = true;
                $return['data'] = __d('ittvn','The locale has been saved.');
            } else {
                $return['data'] = __d('ittvn','The locale could not be saved. Please, try again.');
            }
            $this->set('return', $return);
            $this->set('_serialize', 'return');
        }
        $this->loadModel('Extensions.Languages');
        $languages = $this->Languages->find()->select(['id', 'i18n','name'])->where(['status' => 1, 'delete' => 0]);
        $domain =  $this->Locales->find('list', ['keyField' => 'domain', 'valueField' => 'domain', 'limit' => 100])->group('domain');
        $this->set(compact('locale','languages','domain'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Locale id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $locale = $this->Locales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locale = $this->Locales->patchEntity($locale, $this->request->data);
            if ($this->Locales->save($locale)) {
                $this->Flash->success(__('The locale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The locale could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Locales, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $this->set(compact('locale'));
        $this->set('_serialize', ['locale']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Locale id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $locale = $this->Locales->get($id);
        if ($this->Locales->delete($locale)) {
            $this->Flash->success(__('The locale has been deleted.'));
        } else {
            $this->Flash->error(__('The locale could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function generate() {
        //$paths[] = realpath(APP) . DS;
        $paths = APP;
        if (!is_dir(APP . 'Locale')) {
            mkdir(APP . 'Locale');
        }

        $this->loadModel('Extensions.Languages');
        $languages = $this->Languages->find()->select(['id', 'i18n'])->where(['status' => 1, 'delete' => 0]);
        $domains = $this->Locales->find('list', ['keyField' => 'domain', 'valueField' => 'domain'])->group('domain')->order('id');

        if ($languages->count() > 0) {
            foreach ($languages as $language) {
                $path_output = APP . 'Locale' . DS . $language->i18n;
                if (!is_dir($path_output)) {
                    mkdir($path_output);
                }

                foreach ($domains as $domain) {
                    $locales = $this->Locales->find()
                            ->select(['Locales.id', 'Locales.msgid', 'Locales.domain', 'Locales.description'])
                            ->contain(['Translates' => function($q) use($language) {
                                    return $q->where(['language_id' => $language->id]);
                                }])
                            ->where(['Locales.domain' => $domain]);

                    if ($locales->count() > 0) {
                        $output = $this->_writeHeader();
                        foreach ($locales as $locale) {
                            if(!empty($locale->description)){
                                $references = json_decode($locale->description, true);
                                $files = $references[0]['references'];
                                $occurrences = [];
                                foreach ($files as $file => $lines) {
                                    $lines = array_unique($lines);
                                    $occurrences[] = $file . ':' . implode(';', $lines);
                                }
                                $occurrences = implode("\n#: ", $occurrences);
                            }else{
                                $occurrences = '';
                            }
                            $header = '#: ' . str_replace(DS, '/', str_replace($paths, '', $occurrences)) . "\n";

                            $sentence = '';
                            $sentence .= "msgid \"{$locale->msgid}\"\n";
                            if (count($locale->translates) > 0) {
                                $sentence .= "msgstr \"{$locale->translates[0]->msgstr}\"\n\n";
                            } else {
                                $sentence .= "msgstr \"\"\n\n";
                            }
                            $output .= $header . $sentence;
                        }
                        $filename = $domain . '.po';
                        $File = new File($path_output . DS . $filename);
                        $File->write($output);
                        $File->close();
                    }
                }
            }
        }
        //$this->clearCache(CACHE . 'persistent/');
        Cache::clear(false, '_cake_core_');
        $this->Flash->success(__('Generate file po successfull.'));
        return $this->redirect(['action' => 'index']);
    }

    protected function clearCache($path) {
        $Folder = new Folder($path);
        $files = $Folder->findRecursive();
        foreach ($files as $i => $file) {
            $File = new File($file);
            $File->delete();
        }
    }

    /**
     * Build the translation template header
     *
     * @return string Translation template header
     */
    protected function _writeHeader() {
        $output = "# LANGUAGE translation of CakePHP Application\n";
        $output .= "# Copyright ITTVN <info@ittvn.com>\n";
        $output .= "#\n";
        $output .= "#, fuzzy\n";
        $output .= "msgid \"\"\n";
        $output .= "msgstr \"\"\n";
        $output .= "\"Project-Id-Version: 1.0\\n\"\n";
        $output .= "\"POT-Creation-Date: " . date("Y-m-d H:iO") . "\\n\"\n";
        $output .= "\"PO-Revision-Date: YYYY-mm-DD HH:MM+ZZZZ\\n\"\n";
        $output .= "\"Last-Translator: NAME <EMAIL@ADDRESS>\\n\"\n";
        $output .= "\"Language-Team: LANGUAGE <EMAIL@ADDRESS>\\n\"\n";
        $output .= "\"MIME-Version: 1.0\\n\"\n";
        $output .= "\"Content-Type: text/plain; charset=utf-8\\n\"\n";
        $output .= "\"Content-Transfer-Encoding: 8bit\\n\"\n";
        $output .= "\"Plural-Forms: nplurals=INTEGER; plural=EXPRESSION;\\n\"\n\n";
        return $output;
    }

    public function reload() {
        set_time_limit(0);
        $files = $this->_searchFiles([ROOT]);
        $this->_extractTokens($files);
        if (count($this->_translations) > 0) {
            foreach ($this->_translations as $domain => $translations) {
                if (count($translations) > 0) {
                    foreach ($translations as $msgid => $references) {
                        $check = $this->Locales->find()->where(['msgid' => $msgid,'domain' => $domain]);
                        if($check->count() > 0){
                            $locale = $check->first();
                            $locale->description = json_encode($references);
                        }else{
                            $locale = $this->Locales->newEntity([
                                'msgid' => $msgid,
                                'domain' => $domain,
                                'description' => json_encode($references)
                            ]);
                        }
                        $this->Locales->save($locale);
                    }
                }
            }
        }
        $this->Flash->success(__('Load all key translate.'));
        return $this->redirect(['action' => 'index']);
    }

    protected function _searchFiles($paths) {
        $pattern = false;
        $exclude_paths[] = TMP;
        $exclude_paths[] = TESTS;
        $exclude = [];
        if (count($exclude_paths) > 0) {
            foreach ($exclude_paths as $e) {
                if (DS !== '\\' && $e[0] !== DS) {
                    $e = DS . $e;
                }
                $exclude[] = preg_quote($e, '/');
            }
            $pattern = '/' . implode('|', $exclude) . '/';
        }
        $files = [];
        foreach ($paths as $path) {
            $Folder = new Folder($path);
            $files = $Folder->findRecursive('.*\.(php|ctp|thtml|inc|tpl)', true);
            if (!empty($pattern)) {
                foreach ($files as $i => $file) {
                    if (preg_match($pattern, $file)) {
                        unset($files[$i]);
                    }
                }
                $files = array_values($files);
            }
            $files = array_merge($files, $files);
        }
        return $files;
    }

    protected function _extractTokens($files) {
        foreach ($files as $file) {
            $this->_file = $file;
            $code = file_get_contents($file);
            $allTokens = token_get_all($code);

            $this->_tokens = [];
            foreach ($allTokens as $token) {
                if (!is_array($token) || ($token[0] !== T_WHITESPACE && $token[0] !== T_INLINE_HTML)) {
                    $this->_tokens[] = $token;
                }
            }
            unset($allTokens);
            $this->_parse('__', ['singular']);
            $this->_parse('__n', ['singular', 'plural']);
            $this->_parse('__d', ['domain', 'singular']);
            $this->_parse('__dn', ['domain', 'singular', 'plural']);
            $this->_parse('__x', ['context', 'singular']);
            $this->_parse('__xn', ['context', 'singular', 'plural']);
            $this->_parse('__dx', ['domain', 'context', 'singular']);
            $this->_parse('__dxn', ['domain', 'context', 'singular', 'plural']);
        }
    }

    protected function _parse($functionName, $map) {
        $count = 0;
        $tokenCount = count($this->_tokens);

        while (($tokenCount - $count) > 1) {
            $countToken = $this->_tokens[$count];
            $firstParenthesis = $this->_tokens[$count + 1];
            if (!is_array($countToken)) {
                $count++;
                continue;
            }

            list($type, $string, $line) = $countToken;
            if (($type == T_STRING) && ($string === $functionName) && ($firstParenthesis === '(')) {
                $position = $count;
                $depth = 0;

                while (!$depth) {
                    if ($this->_tokens[$position] === '(') {
                        $depth++;
                    } elseif ($this->_tokens[$position] === ')') {
                        $depth--;
                    }
                    $position++;
                }

                $mapCount = count($map);
                $strings = $this->_getStrings($position, $mapCount);

                if ($mapCount === count($strings)) {
                    extract(array_combine($map, $strings));
                    $domain = isset($domain) ? $domain : 'default';
                    $details = [
                        'file' => $this->_file,
                        'line' => $line,
                    ];
                    if (isset($plural)) {
                        $details['msgid_plural'] = $plural;
                    }
                    if (isset($context)) {
                        $details['msgctxt'] = $context;
                    }
                    $this->_addTranslation($domain, $singular, $details);
                } elseif (strpos($this->_file, CAKE_CORE_INCLUDE_PATH) === false) {
                    $this->_markerError($this->_file, $line, $functionName, $count);
                }
            }
            $count++;
        }
    }

    protected function _getStrings(&$position, $target) {
        $strings = [];
        $count = count($strings);
        while ($count < $target && ($this->_tokens[$position] === ',' || $this->_tokens[$position][0] == T_CONSTANT_ENCAPSED_STRING || $this->_tokens[$position][0] == T_LNUMBER)) {
            $count = count($strings);
            if ($this->_tokens[$position][0] == T_CONSTANT_ENCAPSED_STRING && $this->_tokens[$position + 1] === '.') {
                $string = '';
                while ($this->_tokens[$position][0] == T_CONSTANT_ENCAPSED_STRING || $this->_tokens[$position] === '.') {
                    if ($this->_tokens[$position][0] == T_CONSTANT_ENCAPSED_STRING) {
                        $string .= $this->_formatString($this->_tokens[$position][1]);
                    }
                    $position++;
                }
                $strings[] = $string;
            } elseif ($this->_tokens[$position][0] == T_CONSTANT_ENCAPSED_STRING) {
                $strings[] = $this->_formatString($this->_tokens[$position][1]);
            } elseif ($this->_tokens[$position][0] == T_LNUMBER) {
                $strings[] = $this->_tokens[$position][1];
            }
            $position++;
        }
        return $strings;
    }

    /**
     * Format a string to be added as a translatable string
     *
     * @param string $string String to format
     * @return string Formatted string
     */
    protected function _formatString($string) {
        $quote = substr($string, 0, 1);
        $string = substr($string, 1, -1);
        if ($quote === '"') {
            $string = stripcslashes($string);
        } else {
            $string = strtr($string, ["\\'" => "'", "\\\\" => "\\"]);
        }
        $string = str_replace("\r\n", "\n", $string);
        return addcslashes($string, "\0..\37\\\"");
    }

    /**
     * Indicate an invalid marker on a processed file
     *
     * @param string $file File where invalid marker resides
     * @param int $line Line number
     * @param string $marker Marker found
     * @param int $count Count
     * @return void
     */
    protected function _markerError($file, $line, $marker, $count) {
        $this->_errors[] = sprintf("Invalid marker content in %s:%s\n* %s(", $file, $line, $marker);
        $count += 2;
        $tokenCount = count($this->_tokens);
        $parenthesis = 1;

        while ((($tokenCount - $count) > 0) && $parenthesis) {
            if (is_array($this->_tokens[$count])) {
                $this->_errors[] = $this->_tokens[$count][1];
            } else {
                $this->_errors[] = $this->_tokens[$count];
                if ($this->_tokens[$count] === '(') {
                    $parenthesis++;
                }

                if ($this->_tokens[$count] === ')') {
                    $parenthesis--;
                }
            }
            $count++;
        }
        $this->_errors[] = "\n";
    }

    /**
     * Add a translation to the internal translations property
     *
     * Takes care of duplicate translations
     *
     * @param string $domain The domain
     * @param string $msgid The message string
     * @param array $details Context and plural form if any, file and line references
     * @return void
     */
    protected function _addTranslation($domain, $msgid, $details = []) {
        $context = isset($details['msgctxt']) ? $details['msgctxt'] : "";

        if (empty($this->_translations[$domain][$msgid][$context])) {
            $context = 0;
            $this->_translations[$domain][$msgid][$context] = [
                'msgid_plural' => false
            ];
        }

        if (isset($details['msgid_plural'])) {
            $this->_translations[$domain][$msgid][$context]['msgid_plural'] = $details['msgid_plural'];
        }

        if (isset($details['file'])) {
            $line = isset($details['line']) ? $details['line'] : 0;
            $this->_translations[$domain][$msgid][$context]['references'][$details['file']][] = $line;
        }
    }

}
