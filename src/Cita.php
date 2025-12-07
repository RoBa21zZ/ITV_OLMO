<?php
class Cita {
    private $id_cita;
    private $id_usuario;
    private $id_vehiculo;
    private $matricula;
    private $fecha_cita;
    private $hora_cita;
    private $estado;

    


    


    /**
     * Get the value of id_usuario
     */ 
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */ 
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Get the value of id_vehiculo
     */ 
    public function getId_vehiculo()
    {
        return $this->id_vehiculo;
    }

    /**
     * Set the value of id_vehiculo
     *
     * @return  self
     */ 
    public function setId_vehiculo($id_vehiculo)
    {
        $this->id_vehiculo = $id_vehiculo;

        return $this;
    }

    public function get_Matricula_Cita()
    {
        return $this->matricula;
    }



    /**
     * Get the value of fecha_cita
     */ 
    public function getFecha_cita()
    {
        return $this->fecha_cita;
    }

    /**
     * Set the value of fecha_cita
     *
     * @return  self
     */ 
    public function setFecha_cita($fecha_cita)
    {
        $this->fecha_cita = $fecha_cita;

        return $this;
    }

    /**
     * Get the value of hora_cita
     */ 
    public function getHora_cita()
    {
        return $this->hora_cita;
    }

    /**
     * Set the value of hora_cita
     *
     * @return  self
     */ 
    public function setHora_cita($hora_cita)
    {
        $this->hora_cita = $hora_cita;

        return $this;
    }

    /**
     * Get the value of estado
     */ 
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */ 
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get the value of id_cita
     */ 
    public function getId_cita()
    {
        return $this->id_cita;
    }

    /**
     * Set the value of id_cita
     *
     * @return  self
     */ 
    public function setId_cita($id_cita)
    {
        $this->id_cita = $id_cita;

        return $this;
    }
}







?>