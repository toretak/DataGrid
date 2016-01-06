<?php
/**
 * This file is part of the Mesour DataGrid (http://grid.mesour.com)
 *
 * Copyright (c) 2015 Matouš Němec (http://mesour.com)
 *
 * For full licence and copyright please view the file licence.md in root of this project
 */

namespace Mesour\DataGrid\Column;

use Mesour;


/**
 * @author Matouš Němec <matous.nemec@mesour.com>
 */
abstract class InlineEdit extends Filtering implements IInlineEdit
{

    private $editable = TRUE;

    private $related;

    public function getBodyAttributes($data, $need = TRUE, $rawData = [])
    {
        $attributes = parent::getBodyAttributes($data, $need, $rawData);
        if ($this->hasEditable() && $this->related) {
            $attributes = array_merge($attributes, [
                'data-editable-related' => str_replace('\\', '', $this->related)
            ]);
        }
        return parent::mergeAttributes($data, $attributes);
    }

    public function setEditable($editable = TRUE)
    {
        $this->editable = (bool)$editable;
        return $this;
    }

    public function hasEditable()
    {
        if (!$this->editable) {
            return FALSE;
        }
        $editable = $this->getGrid()->getExtension('IEditable', FALSE);
        return $editable instanceof Mesour\DataGrid\Extensions\Editable\IEditable
        && $editable->isAllowed()
        && !$editable->isDisabled();
    }

    public function setRelated($table)
    {
        $this->related = (string)$table;
        return $this;
    }

    public function getRelated()
    {
        return $this->related;
    }

}
