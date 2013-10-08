<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Short description for file
 *
 * PHP version 5.3.+
 *
 * @category   
 * @package    
 * @author     Marius Schmidt <marius.schmidt@gridground.de>
 * @copyright  2010-2012 Gridground UG (haftungsbeschränkt)
 * @license    http://www.gridground.de/license/brickscout.txt
 * @version    GIT: $Id$
 * @link       
 * @see        
 * @since      File available since 
 */

/**
 * Short description for class
 *
 * @category   
 * @package    
 * @author     Marius Schmidt <marius.schmidt@gridground.de>
 * @copyright  2010-2012 Gridground UG (haftungsbeschränkt)
 * @license    http://www.gridground.de/license/brickscout.txt
 * @version    Release: @package_version@
 * @link       
 * @see        
 * @since      Class available since Release 
 */
class TreePrinter {

    public $indent = 0;
    public $listOptions = array();
    public $listItemOptions = array();
    public $printContentCallback = NULL;
    public $callbackOptions = array();

    public function printTree(array $tree, $flush = TRUE) {
        ob_start();
        $firstItem = true;
        $currentLevel = 0;
        $indent = $this->indent;
        foreach ($tree as $node) {
            if ($node->level > $currentLevel) {
                $this->openList($indent, $node);
            } elseif ($node->level === $currentLevel) {
                $this->closeListItem($indent);
            } else {
                $this->writeThirdGradeRelative($indent, $currentLevel, $node);
            }
            $this->openListItem($indent, $node);
            $currentLevel = $node->level;
            $this->writeNodeContent($indent, $node);
        }
        while ($currentLevel > 0) {
            $this->closeListItem($indent);
            $this->closeList($indent);
            $currentLevel--;
        }

        $output = ob_get_contents();
        if ($flush) {
            ob_end_flush();
        } else {
            ob_end_clean();
        }
        
        return $output;
    }

    private function openList(&$indent, $treeNode) {
        $this->writeNewLineWithIndent($indent);
        echo CHtml::openTag('ul');
        $indent++;
    }

    private function writeNewLineWithIndent($indent = 0) {
        echo "\n" . str_repeat("    ", $indent);
    }

    private function openListItem(&$indent, $treeNode) {
        $htmlOptions = array(
            'id' => 'node_' . $treeNode->id,
            'title' => $treeNode->name,
            'class' => (!$treeNode->isLeaf()) ? 'folder' : NULL,
        );
        $this->writeNewLineWithIndent($indent);
        echo CHtml::openTag('li', $htmlOptions);
        $indent++;
    }

    private function closeListItem(&$indent) {
        $indent--;
        $this->writeNewLineWithIndent($indent);
        echo CHtml::closeTag('li');
    }

    private function closeList(&$indent) {
        $indent--;
        $this->writeNewLineWithIndent($indent);
        echo CHtml::closeTag('ul');
    }

    private function writeThirdGradeRelative(&$indent, $currentLevel, $treeNode) {
        $levelDiff = $currentLevel - $treeNode->level;
        $this->closeListItem($indent);
        for ($levelDiff = $currentLevel - $treeNode->level; $levelDiff > 0; $levelDiff--) {
            $this->closeList($indent);
            $this->closeListItem($indent);
        }
    }

    private function writeNodeContent(&$indent, $treeNode) {
        $this->writeNewLineWithIndent($indent);
        if (is_callable($this->printContentCallback)) {
            if (!empty($this->callbackOptions)) {
                echo call_user_func($this->printContentCallback, $indent, $treeNode, $this->callbackOptions);
            } else {
                echo call_user_func($this->printContentCallback, $indent, $treeNode);
            }
        } else {
            echo $treeNode->name;
        }
    }

}
