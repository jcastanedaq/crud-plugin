<?php

class CP_CRUD_JSON{

    public function add_item($data, $nombres, $apellidos, $email, $media){
        //si esta vacio, generar estructura
        if($data == ''){

            $data = [
                "tabla" => [
                    "nombre" => ''
                ],
                "items" => [
                    [
                        "id" => 1,
                        "nombres" => $nombres,
                        "apellidos" => $apellidos,
                        "email" => $email,
                        "media" => $media

                    ]
                ]
            ];


        } else {

            $items_decode = json_decode($data, true);
            $items = $items_decode['items'];
            $last_item = end($items);
            $last_item_id = $last_item['id'];
            $insert_item_id = ++$last_item_id;

            $items_decode['items'][] = [
                "id" => $insert_item_id,
                        "nombres" => $nombres,
                        "apellidos" => $apellidos,
                        "email" => $email,
                        "media" => $media
            ];

            $data = $items_decode;


        }

        return $data;

    }

    public function read_item($data){

        
    }

    public function update_item($ar_user, $iduser, $nombre, $apellidos, $email, $media){
        
    }

    public function delete_item($ar_user, $id_delete){

        
    }
}