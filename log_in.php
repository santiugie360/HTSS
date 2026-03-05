<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>document</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <!-- IDs y nombres de los inputs:
       name -> Nombre
       password -> Contraseña
       confirm -> Confirmar contraseña
       birthdate -> Fecha de nacimiento
  -->

  <main class="bg-white p-6 rounded-lg shadow-md w-80">
    <h1 class="text-lg font-semibold text-gray-700 mb-4 text-center">Registro</h1>

    <form id="loginForm" class="space-y-3">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input id="name" name="name" type="text" required class="mt-1 w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring focus:ring-blue-200" />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
        <input id="password" name="password" type="password" minlength="6" required class="mt-1 w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring focus:ring-blue-200" />
      </div>

      <div>
        <label for="confirm" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
        <input id="confirm" name="confirm" type="password" minlength="6" required class="mt-1 w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring focus:ring-blue-200" />
      </div>

      <div>
        <label for="birthdate" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
        <input id="birthdate" name="birthdate" type="date" required class="mt-1 w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring focus:ring-blue-200" />
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Crear cuenta</button>
      <p id="msg" class="text-sm text-center mt-2"></p>
    </form>
  </main>

  <script>
    const form = document.getElementById('loginForm');
    const msg = document.getElementById('msg');

    form.addEventListener('submit', e => {
      e.preventDefault();
      const name = form.name.value.trim();
      const pass = form.password.value;
      const conf = form.confirm.value;

      if (pass !== conf) {
        msg.textContent = 'Las contraseñas no coinciden';
        msg.className = 'text-red-600 text-sm text-center mt-2';
      } else {
        msg.textContent = `Cuenta creada correctamente. Bienvenido, ${name}!`;
        msg.className = 'text-green-600 text-sm text-center mt-2';
        form.reset();
      }
    });
  </script>
</body>
</html>