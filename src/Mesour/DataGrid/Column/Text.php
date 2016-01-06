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
class Text extends InlineEdit implements IExportable
{

    public function getHeaderAttributes()
    {
        return array_merge([
            'class' => 'grid-column-' . $this->getName()
        ], parent::getHeaderAttributes());
    }

    public function getBodyAttributes($data, $need = TRUE, $rawData = [])
    {
        $attributes = parent::getBodyAttributes($data);
        if ($this->hasEditable()) {
            $attributes = array_merge($attributes, [
                'data-editable' => $this->getName(),
                'data-editable-type' => 'text'
            ]);
        }
        $attributes['class'] = 'type-text';
        return parent::mergeAttributes($data, $attributes);
    }

    public function getBodyContent($data, $rawData)
    {
        $fromCallback = $this->tryInvokeCallback([$this, $rawData]);
        if ($fromCallback !== self::NO_CALLBACK) {
            return $fromCallback;
        }
        return parent::getBodyContent($data, $rawData);
    }

    public function attachToFilter(Mesour\DataGrid\Extensions\Filter\IFilter $filter, $hasCheckers)
    {
        parent::attachToFilter($filter, $hasCheckers);
        $item = $filter->addTextFilter($this->getName(), $this->getHeader());
        $item->setCheckers($hasCheckers);
    }

}
