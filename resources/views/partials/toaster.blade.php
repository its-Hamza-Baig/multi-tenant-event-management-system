

<style>
    .fade-out {
        opacity: 0;
        transition: opacity 0.5s ease-out;
    }
</style>
@if (session('success'))

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
    <div class="w-full"> 
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="float: right">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div> 
</div>
@endif

@if (session('error'))
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
    <div class="w-full"> 
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="float: right">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div> 
</div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.add('fade-out'); 
                setTimeout(() => alert.remove(), 500); 
            });
        }, 3000); 
    });
</script>