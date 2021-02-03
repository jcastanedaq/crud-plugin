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

    public function read_items($data){

        $output = '';

        if($data != ''){
            $data = json_decode($data, true);
            
            foreach($data['items'] as $v){
                $id = $v['id'];
                $nombres = $v['nombres'];
                $apellidos = $v['apellidos'];
                $email = $v['email'];
                $media = $v['media'];
                $output .= "
                <tr data-item='$id'>
                <td data-item='$id'>
                <img class='cp-media' src='$media' alt='$nombres $apellidos'>
            </td>
            <td>$nombres</td>
            <td>$apellidos</td>
            <td>$email</td>
            <td>
                <span data-edit='$id' class='btn btn-floating waves-effect waves-light'>    
                    <i class='tiny material-icons'>mode_edit</i>
                </span>
            </td>
            <td>
                <span data-remove='$id' class='btn btn-floating waves-effect waves-light red darken-1'>
                    <i class='tiny material-icons'>close</i>
                </span>
            </td>
            </tr>";
            }
        }

        return $output;

        
    }

    public function update_item($ar_user, $iduser, $nombres, $apellidos, $email, $media){
        
        $ar_user = json_decode( $ar_user, true);

        foreach($ar_user['items'] as $k => $v){

            $id = $v['id'];

            if($iduser == $id){
                $ar_user['items'][$k]['nombres'] = $nombres;
                $ar_user['items'][$k]['apellidos'] = $apellidos;
                $ar_user['items'][$k]['email'] = $email;
                $ar_user['items'][$k]['media'] = $media;

                break;

            }
        
        }

        return $ar_user;

    }

    public function delete_item($ar_user, $id_delete){

        $ar_user = json_decode( $ar_user, true);

        foreach($ar_user['items'] as $k => $v){

            $id = $v['id'];

            if($id_delete == $id){
                unset($ar_user['items'][$k]);

                break;

            }
        
        }

        return $ar_user;



        
    }
}