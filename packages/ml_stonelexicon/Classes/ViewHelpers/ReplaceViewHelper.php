<?php
namespace Simplesigns\MlStonelexicon\ViewHelpers;

use Closure;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

// Benutzerdefinierter ViewHelper zur Ersetzung von Zeichenketten
class ReplaceViewHelper extends AbstractViewHelper {
    // Deklaration der Eigenschaften mit Typ 'mixed'
    protected mixed $searchFor;
    protected mixed $replaceWith;
    protected mixed $revert;

    // Initialisierung der Argumente, die der ViewHelper akzeptiert
    public function initializeArguments(): void {
        parent::initializeArguments();
        $this->registerArgument('searchFor', 'mixed', 'Der zu suchende String', false, '');
        $this->registerArgument('replaceWith', 'mixed', 'Der Ersatzstring', false, '');
        $this->registerArgument('revert', 'mixed', 'Gibt an, ob die Ersetzung umgekehrt werden soll', false, 0);
    }

    // Render-Methode, die die statische Ersetzungsmethode aufruft
    public function render() {
        $searchFor = $this->arguments['searchFor'];
        $replaceWith = $this->arguments['replaceWith'];
        $revert = $this->arguments['revert'];

        return static::replaceStatic(
            compact('searchFor', 'replaceWith', 'revert'),
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    // Statische Methode zur Durchführung der eigentlichen Ersetzung
    public static function replaceStatic(array $arguments, Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $string = $renderChildrenClosure();
        $searchFor = $arguments['searchFor'];
        $replaceWith = $arguments['replaceWith'];
        $revert = $arguments['revert'];
    
        if ($revert) {
            // Umkehrung der Ersetzung
            return strtr($string, [$replaceWith => $searchFor]);
        }
    
        // Durchführung der Ersetzung
        return str_replace($searchFor, $replaceWith, $string);
    }
}
