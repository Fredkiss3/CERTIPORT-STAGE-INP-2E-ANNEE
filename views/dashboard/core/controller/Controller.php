<?php


namespace Core\Controller;


class Controller {

    /**
     * STATUSES
     */
    const FORBIDDEN = "403 Forbidden";
    const NOT_FOUND = "404 Not Found";
    const REDIRECTED = "301 Moved Permanently";
    const OK = "200 Ok";

    /**
     * For view
     */
    protected $viewPath;
    protected $layout;

    /**
     * ERRORS HANDLER
     */
    protected $Page404;
    protected $Page500;
    protected $Page403;

    /**
     * Page not found
     */
    public function notFound($to = null) {
        header("HTTP/1.0 " . self::NOT_FOUND);

        if (!is_null($this->Page404)) {
            $this->redirect($this->Page404);
        }
        die("Page non trouvée.");
    }

    /**
     * Page not found
     */
    public function forbidden() {

        header("HTTP/1.0 " . self::FORBIDDEN);

        if (!is_null($this->Page403)) {
            $this->redirect($this->Page403);
        }
        die("Accès interdit");
    }

    /**
     * @param $to
     * @param string $status
     */
    public function redirect($to) {
        header("HTTP/1.0 " . self::REDIRECTED,  false, 301);
        echo <<<HTML
        <script  type="text/javascript">
            window.location.href = "$to"
        </script>
HTML;
        exit();
    }


    /**
     * Render a view
     * @param $view
     */
    public function render($view, $vars = array()) {
        ob_start();
        extract($vars);
        require($this->viewPath . str_replace(".", "/", $view) . ".php");
        $content = ob_get_clean();
        require($this->viewPath . "layouts/" . $this->layout . ".php");
    }

}