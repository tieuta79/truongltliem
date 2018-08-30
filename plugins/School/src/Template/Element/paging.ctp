<?php
$defaultModal = $this->request->controller;
if (isset($modal)) {
    $defaultModal = $modal;
}
if (isset($this->request->paging[$defaultModal]['pageCount']) && $this->request->paging[$defaultModal]['pageCount'] > 1) {
    ?>
    <ul class="pagination">
        <?php
        if (isset($url)) {
            $this->Paginator->options([
                'url' => $url
            ]);
        }
        ?>
        <?= $this->Paginator->prev(__d('ittvn', 'Prev')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__d('ittvn', 'Next')) ?>
    </ul>
<?php } ?>