<?php
namespace Simplesigns\MlStonelexicon\ViewHelpers\Widget;

use TYPO3Fluid\Fluid\Core\Widget\AbstractWidgetViewHelper;
use Simplesigns\MlStonelexicon\ViewHelpers\Widget\Controller\AutocompleteController;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

/**
 * Simple autocomplete widget
 *
 * @api
 */
class AutocompleteViewHelper extends AbstractWidgetViewHelper
{
    /**
     * @var bool
     */
    protected bool $ajaxWidget = true;

    /**
     * @var AutocompleteController
     */
    protected AutocompleteController $controller;

    public function __construct(AutocompleteController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param QueryResult $objects
     * @param string $for
     * @param string $searchProperty
     * @return string
     */
    public function render(QueryResult $objects, string $for, string $searchProperty): string
    {
        return $this->initiateSubRequest();
    }
}
