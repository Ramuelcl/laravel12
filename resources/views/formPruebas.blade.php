<x-layouts.app title="Formulario">
  <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="relative h-full p-4 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
      <!-- Mostrar todos los mensajes de sesión -->
      <x-forms.flash-message :messages="session("messages", [])" />
      <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-200">Formulario de Pruebas</h1>

      <form method="POST" action="{{ route("formulario.store") }}" enctype="multipart/form-data">
        @csrf

        {{-- Contenedor de dos columnas --}}
        <div class="flex gap-4">
          {{-- Columna 1 --}}
          <div class="flex-1">
            {{-- name --}}
            <div class="mb-4">
              <x-forms.input-text id="name" name="name" placeholder="Ingresa tu nombre" label="name"
                :labelRequired="true" labelWidth="w-64" labelPosition="left" />
            </div>

            {{-- email --}}
            <div class="mb-4">
              <x-forms.input-text id="email" name="email" type="email"
                placeholder="Ingresa tu correo electrónico" class="form-control w-64" required
                label="Correo Electrónico" labelPosition="left" labelWidth="w-64" :labelRequired="true" wireModel="email" />
            </div>

            {{-- password --}}
            <div class="mb-4">
              <x-forms.input-text id="password" name="password" placeholder="Ingresa tu password" required
                type="password" label="Contraseña" labelPosition="left" labelWidth="w-64" :labelRequired="true"
                wireModel="password" />
            </div>

            {{-- COLOR --}}
            <div>
              <x-forms.input-colors id="color" name="color" label="Colors" wireModel="color"
                labelPosition="left" />
            </div>
          </div>

          {{-- Columna 2 --}}
          <div class="flex-1">
            {{-- phone --}}
            <div class="mb-4">
              <x-forms.input-text id="phone" name="phone" type="tel" placeholder="Ingresa tu teléfono"
                labelPosition="left" label="Teléfono" class="form-control" labelWidth="w-64" wireModel="phone" />
            </div>

            {{-- SELECT --}}
            <div class="mb-4">
              <x-forms.input-select id="select" name="select" label="Sexo" labelWidth="w-64" :selected="["1"]"
                :multiple="false" :select="['1' => 'Masculino', '2' => 'Femenino', '3' => 'No sabe']" />
            </div>

            {{-- CHECKBOX único --}}
            <div class="mb-4 border-1 p-4 ">
              <x-forms.input-checkbox id="checkbox" name="checkbox" label="Género" :checks="[
                  'male' => 'Masculino',
                  'female' => 'Femenino',
                  'other' => 'Otro',
              ]" checkeds="male"
                wireModel="checkbox" />
            </div>

            {{-- CHECKBOX términos --}}
            <div class="mb-4 border-2 p-4 w-32 rounded-2xl">
              <x-forms.input-checkbox id="terms" name="terms" :multiple="true"
                label="Aceptar términos y condiciones" :checks="[
                    'accept' => 'Acepto los términos y condiciones',
                ]" {{-- checkeds="accept"  --}}
                wireModel="acceptedTerms" :labelRequired="true" labelPosition="left" />
            </div>

          </div>
        </div>

        {{-- Botón de enviar --}}
        <div class="flex items-center justify-between mt-4">
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
