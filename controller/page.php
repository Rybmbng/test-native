<?php 
    $page = (isset($_GET['admin']))?$_GET['admin'] : '';
    switch($page){
        case 'barang':
            include './page/admin/barang.php';
            break;
            case 'selesai':
                include './page/admin/selesai.php';
                break;
        default :
        include './page/admin/index.php';
        break;    
        }

            


?>