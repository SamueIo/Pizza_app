@include('partials.head')
@include('partials.header')


<style>
    .glow-underline {
        position: relative;
        overflow: hidden;
    }

    .glow-underline input {
        position: relative;
        z-index: 1;
        background: transparent;
    }

    .glow-underline::after {
        content: "";
        position: absolute;
        left: -100%;
        bottom: 0;
        width: 50%; /* Ak chceš, aby to bolo len na polovicu */
        height: 2px;
        background: linear-gradient(to right, #3b82f6, #60a5fa, #3b82f6);
        animation: glowing-border 2s linear infinite;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.8), 0 0 15px rgba(59, 130, 246, 0.6);
        transition: opacity 1s ease-out, box-shadow 1s ease-out;
    }


    .glow-underline.no-animation::after {
        opacity: 0;
        box-shadow: none;
    }

    @keyframes glowing-border {
        0% {
            left: -100%;
        }
        100% {
            left: 100%;
        }
    }
</style>

<div class="min-h-screen flex justify-center items-center ">
    <div class="w-[25rem] border border-gray-300 rounded-lg p-6 shadow-md gap-6 flex flex-col items-center">
        <h1 class="text-2xl font-bold mb-4">Prihlásenie</h1>
        <form action="{{route('login')}}" method="POST" class="w-full flex flex-col gap-4">
            @csrf
            <div class="glow-underline" id="email-wrapper">
                <label class="block mb-1 text-sm font-medium" for="email">Email</label>
                <input id="email" name="email" type="email" class="w-full border-b border-gray-400 focus:outline-none p-1" placeholder="Zadajte email" required>
            </div>
            <div class="glow-underline" id="password-wrapper">
                <label class="block mb-1 text-sm font-medium" for="password">Heslo</label>
                <input id="password" name="password" type="password" class="w-full border-b border-gray-400 focus:outline-none p-1" placeholder="Zadajte heslo" required>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
                Prihlásiť sa
            </button>
            {{-- <a href="/registration" class="text-blue-500 hover:underline">Registrácia</a> --}}
        </form>
    </div>
</div>

<script>
    // Funkcia na kontrolu focusu a vyplnenia inputu
    function handleFocusBlur(event) {
        const wrapper = event.target.closest('.glow-underline');
        const input = event.target;


        if (input.value || document.activeElement === input) {
            wrapper.classList.add('no-animation');
        } else {
            wrapper.classList.remove('no-animation');
        }
    }

    // Vyberieme všetky inputy s triedou .glow-underline
    const inputs = document.querySelectorAll('.glow-underline input');

    // Pridáme event listener pre focus, blur a input na každý input
    inputs.forEach(input => {
        input.addEventListener('focus', handleFocusBlur);
        input.addEventListener('blur', handleFocusBlur);
        input.addEventListener('input', handleFocusBlur); // Pri písaní tiež kontrolujeme
    });
</script>



@include('partials.footer')
