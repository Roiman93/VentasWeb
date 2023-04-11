<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\Model_prefixes;
use MVC\Router;
use Classes\Process;
use Classes\Html;
/* clientes */
class CustomerController
{
    public static function index(Router $router)
    {
        session_start();

        isAdmin();


        $formInfo = [
            'id' => 'frm_client',
            'class' => 'my-form-class',
            'header' => "Registro Clientes",
            'fields' => [
                [
                    'type' => 'select',
                    'name' => 'tipo_doc',
                    'label' => 'tipo Documento',
                    'options' => [
                        '' => [ 'label'     => 'Selecione',
                                'disabled'  => true],
                        'CC' => 'Cedula',
                        'Ti' => 'Tarejeta de Identidad',
                        'RS' => 'Registro civil'
                    ],
                    'value' => 'CC'
                ],
                [
                    'type' => 'text',
                    'id'   => 'cedula',
                    'name' => 'cedula',
                    'label' => 'Cedula',
                    'placeholder' => 'Numero de Documento',
                    'data_type' => 'number',
                    'required' => true,
                    'value' => ''
                ],
                [
                    'type' => 'text',
                    'id' => 'p_nombre',
                    'name' => 'p_nombre',
                    'label' => 'Primer Nombre',
                    'placeholder' => 'Escriba su primer nombre',
                    'data_type' => 'text',
                    'value' => ""
                ]
            ]
        ];
        
        
        $formHtml = Html::creatForm($formInfo);
        
        // var_dump($formHtml);
        // exit;
        

      
        // var_dump($campos);
        // exit;


     

        // Model_billing::
        $router->render("pages/Customer", [
            "name" => $_SESSION["nombre"],
            "page" => "Clientes",
            "frm" => $formHtml,
            'script' => '<script type="text/javascript" src="build/js/CustomerFunctions.js"></script>'
        ]);
    }
}
