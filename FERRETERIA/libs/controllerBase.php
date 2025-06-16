    <?php
class ControllerBase {

    public $view;
    protected $model;
    protected $isPublic;

    // Corrección: evitar usar new ViewBase como valor por defecto
    function __construct($view = null)
    {
        $this->view = $view ?? new ViewBase();
    }

    function loadModel($model){
        $url = "models/{$model}Model.php";

        if(file_exists($url))
        {
            require $url;

            $modelName = $model . 'Model';
            $this->model = new $modelName();
        }
    }

    function redirect($url){
        // Asegurarse de que la constante URL esté definida correctamente con define()
        header('Location: ' . constant('URL') . $url);
        exit(); // buena práctica para evitar que se siga ejecutando código después del redireccionamiento
    }

}
?>
