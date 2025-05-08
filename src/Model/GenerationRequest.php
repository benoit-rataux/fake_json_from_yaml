<?php

namespace App\Model;

use App\Entity\Template;

class GenerationRequest {

    private int      $quantity;
    private Template $template;


    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): GenerationRequest {
        $this->quantity = $quantity;
        return $this;
    }

    public function getTemplate(): Template {
        return $this->template;
    }

    public function setTemplate(Template $template): GenerationRequest {
        $this->template = $template;
        return $this;
    }

}