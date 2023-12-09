<div>
    <!-- 削除ボタン -->
    <button wire:click="confirmDelete">削除</button>
</div>
<script>
    document.addEventListener('liveire:load', function () {
        Livewire.on('deleteConfirmed', function () {

            deleteProduct();
        });
    });
</script>