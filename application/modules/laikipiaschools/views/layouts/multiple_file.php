publlic function multiple_upload($field_name, $cof = array()){
    $files = $_FILES[$file_name];
    $file_upload = sizeOf($_FILES[$file_name]['tmp_name];
    $image = array();
    $multiple = array();

    for ($i = 0; $i < $file_upload; $i++){
        $_FILES[$field_name]['name'] = $files['name'][$i];
        $_FILES[$field_name]['type'] = $files['types'][$i];
        $_FILES[$field_name]['error'] = $files['error'][$i];
        $_FILES[field_name]['size'] = $files['size'][$i];

        $upload_path =FCPATH.$conf['upload_path'];
        if(!is_dir($upload_path))
        mkdir($upload_path, 0777, true);

        $config = array(
            'upload_path'=> $upload_path'
            'allowed_types' => $config['allowed_types'],
            'max_size' => 0,
            'encrypt' => true
        );
        $this->Ci->uplod->initialize($config);
        if($this->CI->upload->do_upload($field_name)){
            $data = $this->CI->upload->data();
            chmod(data['full_path', 0777]);

            $multiple[i] = $data['file_name'];
        }
    }
    return $multiple
    }
