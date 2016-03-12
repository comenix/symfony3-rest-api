<?php

namespace Hip\Content\Store;

/**
 * Class ContentBuilder
 * @package Hip\Content\Store
 */
class ContentBuilder
{

    /**
     * @param $id
     * @return mixed
     */
    public function getContentValueObject($id)
    {
        $content = new ContentValueObject();
        $content->setId($id);

        return $id;
    }
}
