<x-layouts.app title="Formulario">
  <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="relative h-full p-4 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
      @if (session("success"))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
          <strong class="font-bold">¡Éxito!</strong>
          <span class="block sm:inline">{{ session("success") }}</span>
          <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg onclick="this.parentElement.parentElement.style.display = 'none';"
              class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20">
              <title>Close</title>
              <path fill-rule="evenodd"
                d="M14.95 5.05a.75.75 0 0 1 1.06 1.06L11.06 10l4.95 4.95a.75.75 0 1 1-1.06 1.06L10 11.06l-4.95 4.95a.75.75 0 0 1-1.06-1.06L8.94 10 4.99 5.05a.75.75 0 0 1 1.06-1.06L10 8.94l4.95-4.95z">
              </path>
            </svg>
          </span>
        </div>
      @endif

      <form method="POST" action="{{ route("formulario.store") }}">
        @csrf
        <div class="mb-4">
          <x-forms.label for="name" position="top" required>
            Nombre
          </x-forms.label>
          <x-forms.input-text id="name" name="name" placeholder="Nombre" />
        </div>
        <div class="mb-6">
          <x-forms.input-password
    id="password"
    name="password"
    placeholder="Ingresa tu contraseña"
    required
    label="Contraseña"
    labelPosition="top"
    :labelRequired="true"
/>
        </div>
        <div class="mb-6">
          ss
        </div>
        <div class="mb-4">
          <x-forms.label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Sexo
          </x-forms.label>
          <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="name" name="name" type="text" placeholder="Nombre" required>
        </div>
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
