<?php
 class Vehiculo {
    private $id_vehiculo;
    private $id_usuario;
    private $matricula;
    private $marca;
    private $modelo;
    private $tipo;
    private $anno_matriculacion;

    
    

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
     * Get the value of matricula
     */ 
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set the value of matricula
     *
     * @return  self
     */ 
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get the value of marca
     */ 
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set the value of marca
     *
     * @return  self
     */ 
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get the value of modelo
     */ 
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set the value of modelo
     *
     * @return  self
     */ 
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of anno_matriculacion
     */ 
    public function getAnno_matriculacion()
    {
        return $this->anno_matriculacion;
    }

    /**
     * Set the value of anno_matriculacion
     *
     * @return  self
     */ 
    public function setAnno_matriculacion($anno_matriculacion)
    {
        $this->anno_matriculacion = $anno_matriculacion;

        return $this;
    }
 }

?>