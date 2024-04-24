<?php
namespace Simplesigns\MlStonelexicon\ViewHelpers\Widget\Controller;

use TYPO3Fluid\Fluid\Core\Widget\AbstractWidgetController;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

class AutocompleteController extends AbstractWidgetController
{
    public function indexAction(): void
    {
        $this->view->assign('id', $this->widgetConfiguration['for']);
    }

    public function autocompleteAction(string $term): string
    {
        $searchProperty = $this->widgetConfiguration['searchProperty'];
        $query = $this->widgetConfiguration['objects']->getQuery();
        $constraint = $query->getConstraint();

        if ($constraint !== null) {
            $query->matching(
                $query->logicalAnd(
                    $constraint,
                    $query->like($searchProperty, '%' . $term . '%')
                )
            );
        } else {
            $query->matching($query->like($searchProperty, '%' . $term . '%'));
        }

        $results = $query->execute();
        $output = [];

        foreach ($results as $singleResult) {
            $val = ObjectAccess::getProperty($singleResult, $searchProperty);
            $output[] = [
                'id' => ObjectAccess::getProperty($singleResult, 'uid'),
                'label' => $val,
                'value' => $val
            ];
        }

        return json_encode($output);
    }
}
