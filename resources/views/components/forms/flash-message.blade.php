<?php // resources/views/components/forms/flash-message.blade.php

use Livewire\Volt\Component;

new class extends Component {
    // Propiedades públicas
    public $message = "";
    public $type = "info"; // Tipo de mensaje: info, success, warning, error
    public $duration = 30; // Duración en segundos (por defecto 30 segundos)
    public $position = "top-left"; // Posición del mensaje
    public $show = false; // Controla si el mensaje se muestra o no

    // Método para mostrar el mensaje
    public function showMessage($message, $type = "info", $duration = 30, $position = "bottom-right")
    {
        $this->message = $message;
        $this->type = $type;
        $this->duration = $duration;
        $this->position = $position;
        $this->show = true;

        // Cerrar el mensaje automáticamente después de la duración especificada
        $this->dispatch("start-timer", duration: $this->duration * 1000);
    }

    // Método para cerrar el mensaje manualmente
    public function closeMessage()
    {
        $this->show = false;
    }
};
?>

<div>
  <!-- Mensaje -->
  @if ($show)
    <div x-data="{
        progress: 100,
        startTimer(duration) {
            const interval = 50; // Intervalo de actualización en milisegundos
            const decrement = (interval / duration) * 100;
            const timer = setInterval(() => {
                this.progress -= decrement;
                if (this.progress <= 0) {
                    clearInterval(timer);
                    @this.closeMessage();
                }
            }, interval);
        }
    }" x-init="startTimer({{ $duration * 1000 }})" @class([
        "fixed z-50 p-4 rounded-lg shadow-lg text-white flex flex-col space-y-2 transition-transform transform",
        "bg-blue-500" => $type === "info",
        "bg-green-500" => $type === "success",
        "bg-yellow-500" => $type === "warning",
        "bg-red-500" => $type === "error",
        "top-4 left-4" => $position === "top-left",
        "top-4 right-4" => $position === "top-right",
        "top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" =>
            $position === "top-center",
        "bottom-4 left-4" => $position === "bottom-left",
        "bottom-4 right-4" => $position === "bottom-right",
        "bottom-1/2 left-1/2 -translate-x-1/2 translate-y-1/2" =>
            $position === "bottom-center",
    ])>
      <!-- Contenido del mensaje -->
      <div class="flex justify-between items-center">
        <span>{{ $message }}</span>
        <button @click="closeMessage" class="ml-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
        </button>
      </div>

      <!-- Barra de progreso -->
      <div class="h-1 bg-white/50 rounded-full overflow-hidden">
        <div class="h-full bg-white transition-all" :style="`width: ${progress}%`"></div>
      </div>
    </div>
  @endif
</div>
{{-- 
  // En un componente Livewire
$this->dispatch('show-message', message: 'Registro guardado correctamente.', type: 'success', duration: 10, position: 'top-right');

// En un controlador
session()->flash('flash-message', [
    'message' => 'Registro guardado correctamente.',
    'type' => 'success',
    'duration' => 10,
    'position' => 'top-right',
]);
 --}}
