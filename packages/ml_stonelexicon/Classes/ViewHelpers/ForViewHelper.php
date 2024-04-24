<?php

namespace Simplesigns\MlStonelexicon\ViewHelpers;

use Closure;
use Traversable;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

class ForViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('each', 'array|\Traversable', 'The array or \TYPO3\CMS\Extbase\Persistence\ObjectStorage to iterate over', true);
        $this->registerArgument('as', 'string', 'The name of the iteration variable', true);
        $this->registerArgument('key', 'string', 'The name of the variable to store the current array key', false, '');
        $this->registerArgument('reverse', 'boolean', 'If enabled, the iterator will start with the last element and proceed reversely', false, false);
        $this->registerArgument('iteration', 'string', 'The name of the variable to store iteration information (index, cycle, isFirst, isLast, isEven, isOdd)', false, 'NULL');
        $this->registerArgument('asort', 'boolean', 'If enabled, the iterator will sort by ksort', false, 'NULL');
    }

    public function render()
    {
        $arguments = $this->arguments;

        return self::renderStatic($arguments, $this->buildRenderChildrenClosure(), $this->renderingContext);
    }

    static public function renderStatic(array $arguments, Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $templateVariableContainer = $renderingContext->getVariableProvider();
        $each = $arguments['each'];

        if ($each === null) {
            return '';
        }

        if (is_object($each) && !$each instanceof Traversable) {
            throw new Exception('ForViewHelper only supports arrays and objects implementing \Traversable interface', 1248728393);
        }

        if ($arguments['reverse']) {
            $each = is_object($each) ? iterator_to_array($each) : $each;
            $each = array_reverse($each);
        }

        if ($arguments['asort']) {
            $each = is_object($each) ? iterator_to_array($each) : $each;
            asort($each);
        }

        $iterationData = [
            'index' => 0,
            'cycle' => 1,
            'total' => count($each),
        ];

        $output = '';
        foreach ($each as $keyValue => $singleElement) {
            $templateVariableContainer->add($arguments['as'], $singleElement);

            if ($arguments['key'] !== '') {
                $templateVariableContainer->add($arguments['key'], $keyValue);
            }

            if ($arguments['iteration'] !== null) {
                $iterationData['isFirst'] = $iterationData['cycle'] === 1;
                $iterationData['isLast'] = $iterationData['cycle'] === $iterationData['total'];
                $iterationData['isEven'] = $iterationData['cycle'] % 4 === 0;
                $iterationData['isOdd'] = !$iterationData['isEven'];
                $templateVariableContainer->add($arguments['iteration'], $iterationData);
                $iterationData['index']++;
                $iterationData['cycle']++;
            }

            $output .= $renderChildrenClosure();

            $templateVariableContainer->remove($arguments['as']);

            if ($arguments['key'] !== '') {
                $templateVariableContainer->remove($arguments['key']);
            }

            if ($arguments['iteration'] !== null) {
                $templateVariableContainer->remove($arguments['iteration']);
            }
        }

        return $output;
    }
}
