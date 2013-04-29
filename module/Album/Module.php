<?php
namespace Album;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Album\Model\Album;
use Album\Model\AlbumTable;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig(){
        return array(
            'factories' => array(
                    'AlbumTableGateway'=> function($sm){
                        $dbAdapter=$sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetProtoype = new ResultSet();
                        $resultSetProtoype->setArrayObjectPrototype(new Album());
                        return new TableGateway('album',$dbAdapter,null,$resultSetProtoype);
                    },
                    'Album\Model\AlbumTable' => function($sm){
                        $tableGateway = $sm->get('AlbumTableGateway');
                        $table = new AlbumTable($tableGateway);
                        return $table;
                    },
                ),
            );
    }
}
