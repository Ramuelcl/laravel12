<?php // resources/views/components/forms/on-off.blade.php
namespace App\Http\Livewire;

use Livewire\Volt\Component;

class OnOff extends Component
{
    // Propiedades públicas
    public $valor; // Valor booleano (1/0, true/false, etc.)
    public $formato = "on/off"; // Formato de visualización: on/off, yes/no, si/no, true/false, 1/0
    public $colorOn = "green"; // Color para el estado "on"
    public $colorOff = "red"; // Color para el estado "off"

    public function mount($valor, $formato = "Yes/No")
    {
        $this->valor = $valor;
        $this->formato = $formato;
    } // Método para obtener el texto según el formato

    public function getTexto($valor)
    {
        switch ($this->formato) {
            case "yes/no":
                return $valor ? "Yes" : "No";
            case "On/Off":
                return $valor ? "On" : "Off";
            case "si/no":
                return $valor ? "Sí" : "No";
            case "true/false":
                return $valor ? "True" : "False";
            case "1/0":
                return $valor ? "1" : "0";
            case "ticket-x":
                return $valor ? "✓" : "✗";
            default:
                // on/off
                return $valor ? "Yes" : "No";
        }
    }

    // Método para obtener el color según el estado
    public function getColor($valor)
    {
        return $valor ? $this->colorOn : $this->colorOff;
    }
} ?>
<div>
  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" {{-- style="background-color: {{ $this->getColor($valor) }}; color: white;"> --}}
    {{-- {{ $this->getTexto($valor) }} --}} $valor </span>
</div>
