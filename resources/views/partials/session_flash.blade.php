@if (session('error'))
    <div class="flex items-center justify-between p-4 mb-4 text-red-600 bg-red-100 border border-red-400 rounded"
        id="errorMessage">
        {{ session('error') }}
        <button class="font-bold text-red-600 hover:text-red-800" onclick="closeMessage('errorMessage')">
            &times;
        </button>
    </div>
@elseif (session('success'))
    <div class="flex items-center justify-between p-4 mb-4 text-green-600 bg-green-100 border border-green-400 rounded"
        id="successMessage">
        {{ session('success') }}
        <button class="font-bold text-green-600 hover:text-green-800" onclick="closeMessage('successMessage')">
            &times;
        </button>
    </div>
@endif

<script>
    function closeMessage(id) {
        document.getElementById(id).style.display = 'none';
    }
</script>
