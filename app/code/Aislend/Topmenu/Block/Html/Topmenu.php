<?php

/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Aislend\Topmenu\Block\Html;

class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
    /**
     * Add sub menu HTML code for current menu item
     *
     * @param \Magento\Framework\Data\Tree\Node $child
     * @param string $childLevel
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string HTML code
     */
    protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
    {
        $html = '';
        if (!$child->hasChildren()) {
            return $html;
        }

        $colStops = null;
        if ($childLevel == 0 && $limit) {
            $colStops = $this->_columnBrake($child->getChildren(), $limit);
        }

        $html .= $childLevel == 0 ? '<div class="mmenu__sub-category-container">' : '';
        $html .= $childLevel == 0 ? '<div class="mmenu__sub-category">' : '';
        $html .= '<ul class="level' . $childLevel . ' submenu">';
        $html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
        $html .= '</ul>';
        $html .= $childLevel == 0 ? '<div class="mmenu__block-sidebar">category-node-3</div>' : '';
        $html .= $childLevel == 0 ? '</div>' : '';
        $html .= $childLevel == 0 ? '<div class="mmenu__block-footer">' . $child->getLevel() . '</div>' : '';
        $html .= $childLevel == 0 ? '</div>' : '';
        return $html;
    }

    protected function _getHtml(
        \Magento\Framework\Data\Tree\Node $menuTree,
        $childrenWrapClass,
        $limit,
        $colBrakes = []
    )
    {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;

        $counter = 1;
        $itemPosition = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        foreach ($children as $child) {
            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="mmenu__parent-category-link ' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }

            //if (count($colBrakes[]) && $colBrakes[$counter]['colbrake']) {
           // if (count($colBrakes[$counter]['colbrake'])) {
           
             //   $html .= '</ul></li><li class="column"><ul>';
          //  }
            

            $parentSpan = ($childLevel == 0) ? '<span class="mmenu__sub-category-trigger"></span>' : '';
            $class_str = strtolower(str_replace(" ", "-", $this->escapeHtml($child->getName())));
            $class = str_replace("&amp;", "n", str_replace(",", "", $class_str));
            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
            $html .= ($childLevel == 0) ? '<div class="mmenu__parent-category">' : '';
            if ($childLevel == 0) {
                $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span class="mmenu__icon icon-' . $class . '"></span><span>' . $this->escapeHtml(
                        $child->getName()
                    ) . '</span></a>' . $parentSpan;
            } else if ($childLevel == 1) {
                $catId = str_replace("category-node-", "", $child->getId());
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $categoryData = $objectManager->create('Magento\Catalog\Model\Category')->load($catId);
                /*<img src="' . $categoryData->getImageUrl() . '">*/

                $imageResizer = $this->getImageResizer();
                $resizedImageUrl = $imageResizer->resizeAndGetUrl($categoryData->getImageUrl(), 120, 120);

                $aMobileUA = array(
					'/iphone/i' => 'iPhone', 
					'/ipod/i' => 'iPod', 
					'/ipad/i' => 'iPad', 
					'/android/i' => 'Android', 
					'/blackberry/i' => 'BlackBerry', 
					'/webos/i' => 'Mobile'
				);
				
				$ismobile = 0;

				//Return true if Mobile User Agent is detected
				foreach($aMobileUA as $sMobileKey => $sMobileOS){
					if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
						$ismobile = 1;
					}
				}
				
				if($ismobile == 0){
					$html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><img width="120" height="120" src="' . $resizedImageUrl . '"><span>' . $this->escapeHtml(
							$child->getName()
						) . '</span></a>' . $parentSpan;
				} else {
					$html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span>' . $this->escapeHtml(
                        $child->getName()
                    ) . '</span></a>' . $parentSpan;
				}
            }
            $html .= ($childLevel == 0) ? '</div>' : '';
            $html .= $this->_addSubMenu(
                    $child,
                    $childLevel,
                    $childrenWrapClass,
                    $limit
                ) . '</li>';
            $itemPosition++;
            $counter++;
        }

        if (count($colBrakes) && $limit) {
            $html = '<li class="column"><ul>' . $html . '</ul></li>';
        }

        return $html;
    }

}
