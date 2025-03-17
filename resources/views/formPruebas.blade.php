<x-layouts.app title="Formulario">
  <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="relative h-full p-4 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
      <!-- Mostrar todos los mensajes de sesión -->
      <x-forms.flash-message :messages="session("messages", [])" />
      <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-200">Formulario de Pruebas</h1>

      <form method="POST" action="{{ route("formulario.store") }}" enctype="multipart/form-data">
        @csrf

        {{-- name --}}
        <div class="mb-4">
          <x-forms.input-text id="name" name="name" placeholder="Ingresa tu nombre" label="name"
            :labelRequired="true" labelWidth="w-64" labelPosition="left" />
        </div>

        {{-- email --}}
        <div class="mb-4">
          <x-forms.input-text id="email" name="email" type="email" placeholder="Ingresa tu correo electrónico"
            class="form-control w-64" required label="Correo Electrónico" labelPosition="left" labelWidth="w-64"
            :labelRequired="true" wireModel="email" />
        </div>

        {{-- password --}}
        <div class="mb-4">
          <x-forms.input-text id="password" name="password" placeholder="Ingresa tu password" required type="password"
            label="Contraseña" labelPosition="left" labelWidth="w-64" :labelRequired="true" wireModel="password" />
        </div>

        {{-- phone --}}
        <div class="mb-4">
          <x-forms.input-text id="phone" name="phone" type="tel" placeholder="Ingresa tu teléfono"
            labelPosition="left" label="Teléfono" class="form-control" labelWidth="w-64" wireModel="phone" />
        </div>

        <div class="mb-4">
          <x-forms.input-select id="select" name="select" label="Sexo"  labelWidth="w-64" selected="1"
            :select="['1' => 'Masculino', '2' => 'Femenino', '3' => 'No sabe']" />
        </div>

        <div class="mb-4">
          ss
        </div>

        {{-- submit --}}
        <div class="flex items-center justify-between">
          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            Enviar
          </button>
        </div>
      </form>
    </div>
  </div>
</x-layouts.app>
