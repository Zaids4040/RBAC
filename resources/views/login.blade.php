<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <title>Login Page</title>

  <style>
    /* Smooth fade-in animation */
    .fade-in {
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Login Card -->
  <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md fade-in">

    <h2 class="text-3xl font-bold text-center text-gray-700 mb-6">Login</h2>
    <form action='{{route("login")}}' method='POST'>
        @csrf
        <!-- Email -->
        <div class="mb-4">
        <label class="block mb-1 text-gray-600">Email</label>
        <input
            id="email"
            type="email"
            name='email'
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none"
            placeholder="Enter your email"
        />
        </div>

        <!-- Password -->
        <div class="mb-4">
        <label class="block mb-1 text-gray-600">Password</label>
        <div class="relative">

            <input
            id="password"
            type="password"
            name='password'
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none"
            placeholder="Enter your password"
            />

            <!-- Show / Hide Icon -->
            <span
            onclick="togglePassword()"
            class="absolute right-3 top-2.5 cursor-pointer text-gray-500 hover:text-gray-700"
            >
            👁️
            </span>
        </div>
        </div>
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif


        <!-- Login Button -->
        <button
        type='submit'
        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-lg transition"
        >
        Login
        </button>
    </form>
  </div>

  <!-- JavaScript -->
  <script>
    function togglePassword() {
      const pass = document.getElementById("password");
      pass.type = pass.type === "password" ? "text" : "password";
    }

    function handleLogin() {
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();

      if (!email || !password) {
        alert("Please enter your email and password.");
        return;
      }

      // You can replace this with backend API call later
      alert("Login successful! (demo)");
    }
  </script>

</body>
</html>
