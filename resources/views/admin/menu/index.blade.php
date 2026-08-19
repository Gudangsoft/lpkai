@extends('layouts.admin')
@section('title', 'Kelola Menu')

@push('styles')
<style>
    .menu-tree, .menu-tree ul { list-style: none; margin: 0; padding: 0; }
    .menu-tree-item {
        background: #fff; border: 1px solid var(--border); border-radius: 10px;
        margin-bottom: 8px;
    }
    .menu-tree-row {
        display: flex; align-items: center; gap: 10px; padding: 10px 14px;
    }
    .drag-handle { cursor: grab; color: #94a3b8; padding: 4px; }
    .drag-handle:active { cursor: grabbing; }
    .menu-tree-label { font-weight: 700; color: var(--primary); flex-shrink: 0; }
    .menu-tree-badge {
        background: #f1f5f9; color: #64748b; font-size: .7rem; font-weight: 700;
        text-transform: uppercase; padding: 3px 9px; border-radius: 20px;
    }
    .menu-tree-actions { margin-left: auto; display: flex; gap: 6px; }
    .menu-sub {
        margin: 0 14px 12px 34px; padding: 10px; min-height: 14px;
        background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px;
    }
    .menu-sub .menu-tree-item { margin-bottom: 6px; }
    .menu-sub .menu-tree-item:last-child { margin-bottom: 0; }
    .sortable-ghost { opacity: .4; border: 2px dashed var(--accent) !important; }
    .menu-toast {
        position: fixed; bottom: 24px; right: 24px; z-index: 2000;
        background: #1a202c; color: #fff; padding: 12px 20px; border-radius: 10px;
        font-size: .85rem; font-weight: 600; box-shadow: 0 8px 24px rgba(0,0,0,.2);
        opacity: 0; transform: translateY(10px); transition: all .25s ease; pointer-events: none;
    }
    .menu-toast.show { opacity: 1; transform: translateY(0); }
    .menu-toast.error { background: #c53030; }
    .menu-hint {
        background: #e8f0fb; border: 1px solid #bae6fd; border-radius: 10px;
        padding: 11px 16px; margin-bottom: 20px; font-size: .83rem; color: #0369a1;
        display: flex; align-items: center; gap: 10px;
    }
</style>
@endpush

@section('content')
<div class="admin-page-header">
    <h1><i class="fas fa-sitemap" style="color:#1a6fc4;margin-right:10px;"></i>Kelola Menu</h1>
    <a href="{{ route('admin.menu.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Menu</a>
</div>

<div class="menu-hint">
    <i class="fas fa-info-circle"></i>
    Seret ikon <i class="fas fa-arrows-alt"></i> untuk mengurutkan atau memindahkan menu ke dalam kotak putus-putus (submenu). Perubahan urutan tersimpan otomatis. Menu yang sudah punya submenu tidak bisa dijadikan submenu menu lain.
</div>

<div id="menu-tree-root-wrap">
    <ul id="menu-tree-root" class="menu-tree" data-parent-id="">
        @foreach($menus as $menu)
        <li class="menu-tree-item" data-id="{{ $menu->id }}" data-has-children="{{ $menu->children->count() > 0 ? '1' : '0' }}">
            <div class="menu-tree-row">
                <span class="drag-handle"><i class="fas fa-arrows-alt"></i></span>
                <span class="menu-tree-label">{{ $menu->label }}</span>
                <span class="menu-tree-badge">{{ ucfirst($menu->type) }}</span>
                @if($menu->is_button)<span class="badge">Tombol</span>@endif
                @if(!$menu->aktif)<span class="badge badge-nonaktif">Nonaktif</span>@endif
                <div class="menu-tree-actions">
                    <a href="{{ route('admin.menu.edit', $menu) }}" class="btn-icon btn-edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-delete"
                            data-confirm="Menu '{{ $menu->label }}' memiliki {{ $menu->children->count() }} sub-menu yang akan ikut terhapus. Lanjutkan?">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <ul class="menu-tree menu-sub" data-parent-id="{{ $menu->id }}">
                @foreach($menu->children as $child)
                <li class="menu-tree-item" data-id="{{ $child->id }}" data-has-children="0">
                    <div class="menu-tree-row">
                        <span class="drag-handle"><i class="fas fa-arrows-alt"></i></span>
                        <span class="menu-tree-label">{{ $child->label }}</span>
                        <span class="menu-tree-badge">{{ ucfirst($child->type) }}</span>
                        @if(!$child->aktif)<span class="badge badge-nonaktif">Nonaktif</span>@endif
                        <div class="menu-tree-actions">
                            <a href="{{ route('admin.menu.edit', $child) }}" class="btn-icon btn-edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.menu.destroy', $child) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" data-confirm="Hapus menu '{{ $child->label }}'?"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </li>
        @endforeach
    </ul>
    @if($menus->isEmpty())
    <p style="text-align:center;padding:32px;color:#718096;">Belum ada menu.</p>
    @endif
</div>

<div id="menuToast" class="menu-toast"></div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lists = document.querySelectorAll('.menu-tree');

    lists.forEach(function (list) {
        Sortable.create(list, {
            group: 'menu-tree',
            animation: 150,
            ghostClass: 'sortable-ghost',
            handle: '.drag-handle',
            onMove: function (evt) {
                const hasChildren = evt.dragged.dataset.hasChildren === '1';
                const targetIsSubmenu = evt.to.classList.contains('menu-sub');
                // An item that is itself a parent can never become someone else's child.
                if (hasChildren && targetIsSubmenu) {
                    return false;
                }
                return true;
            },
            onEnd: function () {
                saveMenuOrder();
            }
        });
    });

    function saveMenuOrder() {
        const items = [];
        document.querySelectorAll('#menu-tree-root > .menu-tree-item').forEach(function (li, index) {
            const sub = li.querySelector(':scope > .menu-sub');
            const childCount = sub ? sub.querySelectorAll(':scope > .menu-tree-item').length : 0;
            li.dataset.hasChildren = childCount > 0 ? '1' : '0';

            items.push({ id: li.dataset.id, parent_id: null, urutan: index });

            if (sub) {
                sub.querySelectorAll(':scope > .menu-tree-item').forEach(function (childLi, childIndex) {
                    items.push({ id: childLi.dataset.id, parent_id: li.dataset.id, urutan: childIndex });
                });
            }
        });

        fetch('{{ route("admin.menu.reorder") }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ items: items }),
        })
        .then(function (res) { return res.json().then(data => ({ ok: res.ok, data })); })
        .then(function (result) {
            showMenuToast(result.data.message || (result.ok ? 'Urutan tersimpan.' : 'Gagal menyimpan.'), !result.ok);
        })
        .catch(function () {
            showMenuToast('Gagal menyimpan urutan. Muat ulang halaman.', true);
        });
    }

    function showMenuToast(text, isError) {
        const toast = document.getElementById('menuToast');
        toast.textContent = text;
        toast.classList.toggle('error', !!isError);
        toast.classList.add('show');
        clearTimeout(window.__menuToastTimer);
        window.__menuToastTimer = setTimeout(function () {
            toast.classList.remove('show');
        }, 2500);
    }
});
</script>
@endpush
