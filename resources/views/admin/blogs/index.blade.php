@extends('admin.layout')
@section('title','Blogs')

@section('content')
<div class="admin-blogs"><!-- SCOPE WRAPPER: prevents navbar overrides -->
  <style>
    /* Page-scoped design tokens (do NOT use :root here) */
    .admin-blogs{
      --bg:#ffffff;
      --surface:#ffffff;
      --surface-2:#f9fafb;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --ring: rgba(37,99,235,.35);

      --primary:#2563eb;      /* blue-600 */
      --primary-600:#1d4ed8;
      --danger:#dc2626;

      --radius:14px;
      --shadow:0 10px 30px rgba(0,0,0,.06);
      --shadow-sm:0 2px 10px rgba(0,0,0,.05);
    }

    .admin-blogs .ab-wrap{ padding: clamp(12px,1.8vw,20px); background: var(--bg); color: var(--text); }
    .admin-blogs .ab-card{
      background: var(--surface); border:1px solid var(--border); border-radius: var(--radius);
      box-shadow: var(--shadow); padding: clamp(16px,2vw,22px);
    }

    .admin-blogs .ab-head{
      display:flex; align-items:flex-end; justify-content:space-between; gap: 12px; flex-wrap: wrap;
      margin-bottom: 12px;
    }
    .admin-blogs .ab-title{ margin:0; font-weight:800; letter-spacing:.2px; }
    .admin-blogs .ab-subtitle{ margin:0; color:var(--muted); }

    .admin-blogs .ab-toolbar{
      display:flex; align-items:center; gap:8px; flex-wrap: wrap; margin-top: 8px;
    }
    .admin-blogs .ab-input{
      background:#fff; border:1px solid var(--border); border-radius:10px; padding:10px 12px;
      box-shadow: var(--shadow-sm); color:var(--text); min-width: 220px;
    }

    .admin-blogs .ab-btn{
      appearance:none; border:1px solid var(--border); border-radius: 999px;
      padding: 10px 14px; font-weight:700; text-decoration:none; cursor:pointer;
      display:inline-flex; align-items:center; gap:.5rem; transition:.18s ease;
      background:#fff; color:var(--text); box-shadow: var(--shadow-sm);
    }
    .admin-blogs .ab-btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow); }
    .admin-blogs .ab-btn:focus-visible{ outline:3px solid var(--ring); outline-offset:2px; }
    .admin-blogs .ab-btn-primary{ background: var(--primary); color:#fff; border-color: transparent; }
    .admin-blogs .ab-btn-primary:hover{ background: var(--primary-600); }
    .admin-blogs .ab-btn-ghost{ background: var(--surface-2); }
    .admin-blogs .ab-btn-sm{ padding:8px 10px; border-radius:10px; }

    .admin-blogs .ab-empty{
      border:1px dashed var(--border); border-radius:12px; background:var(--surface-2);
      padding:22px; color:var(--muted); text-align:center; box-shadow: var(--shadow-sm);
    }

    .admin-blogs .ab-table-wrap{
      margin-top: 12px; border: 1px solid var(--border); border-radius: 12px; overflow: hidden;
      background: var(--surface); box-shadow: var(--shadow);
    }
    .admin-blogs .ab-table{ width:100%; border-collapse: separate; border-spacing:0; font-size:.96rem; }
    .admin-blogs .ab-table thead th{
      text-align:left; padding:12px 14px; background:#fff; border-bottom:1px solid var(--border);
      color:var(--muted); font-weight:800;
    }
    .admin-blogs .ab-table tbody td{
      padding:12px 14px; border-bottom:1px solid var(--border); vertical-align: middle;
    }
    .admin-blogs .ab-table tbody tr:nth-child(even){ background: var(--surface-2); }
    .admin-blogs .ab-table tbody tr:hover{ background:#fff; }

    .admin-blogs .ab-col-id{ width:72px; color:var(--muted); }
    .admin-blogs .ab-col-img{ width:120px; }
    .admin-blogs .ab-col-actions{ width:240px; text-align:right; white-space: nowrap; }

    /* Author cell */
    .admin-blogs .ab-author{ display:inline-flex; align-items:center; gap:10px; }
    .admin-blogs .ab-avatar{
      width:28px; height:28px; border-radius:50%; display:grid; place-items:center;
      background:#eff6ff; color:#1d4ed8; border:1px solid #dbeafe; font-weight:800; font-size:.8rem;
    }
    .admin-blogs .ab-author-name{ font-weight:700; }

    /* Image */
    .admin-blogs .ab-thumb{
      height:40px; width:auto; border-radius:8px; border:1px solid var(--border);
      box-shadow: var(--shadow-sm); object-fit:cover; background:#fff;
    }
    .admin-blogs .ab-thumb.placeholder{
      display:inline-flex; align-items:center; justify-content:center; height:40px; width:72px;
      background: var(--surface-2); color: var(--muted); font-size:.8rem;
      border:1px dashed var(--border); border-radius:8px;
    }

    /* Created date chip */
    .admin-blogs .ab-chip-date{
      display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px;
      background:#ecfeff; color:#155e75; border:1px solid #cffafe; font-weight:700; font-size:.85rem;
    }
    .admin-blogs .ab-ico{ display:inline-flex; }

    /* Responsive stack */
    @media (max-width: 960px){
      .admin-blogs .ab-table-wrap{ border-radius:10px; }
      .admin-blogs .ab-table, 
      .admin-blogs .ab-table thead, 
      .admin-blogs .ab-table tbody, 
      .admin-blogs .ab-table th, 
      .admin-blogs .ab-table td, 
      .admin-blogs .ab-table tr{ display:block; }
      .admin-blogs .ab-table thead{ display:none; }
      .admin-blogs .ab-table tbody tr{ border-bottom:1px solid var(--border); padding:8px 12px; }
      .admin-blogs .ab-table tbody td{
        border:none; padding:8px 0; display:grid; grid-template-columns: 120px 1fr; gap:8px;
      }
      .admin-blogs .ab-table tbody td::before{
        content: attr(data-label);
        font-weight:700; color:var(--muted);
      }
      .admin-blogs .ab-col-actions{ width:auto; text-align:left; }
    }
  </style>

  <div class="ab-wrap">
    <div class="ab-card">
      <div class="ab-head">
        <div>
          <h1 class="ab-title">Blogs</h1>
          <p class="ab-subtitle">Create, edit, and manage blog posts.</p>
        </div>
        <a class="ab-btn ab-btn-primary" href="{{ route('admin.blogs.create') }}">
          <span class="ab-ico" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
          </span>
          New Blog
        </a>
      </div>



      @if ($blogs->isEmpty())
        <div class="ab-empty">No blogs yet.</div>
      @else
        <div class="ab-table-wrap" role="region" aria-label="Blogs table">
          <table class="ab-table">
            <thead>
              <tr>
                <th class="ab-col-id">ID</th>
                <th>Title</th>
                <th>Author</th>
                <th class="ab-col-img">Image</th>
                <th>Created</th>
                <th class="ab-col-actions">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($blogs as $b)
                @php $initial = strtoupper(substr($b->author ?? 'U', 0, 1)); @endphp
                <tr>
                  <td class="ab-col-id" data-label="ID">#{{ $b->id }}</td>
                  <td data-label="Title"><strong>{{ $b->title }}</strong></td>
                  <td data-label="Author">
                    <span class="ab-author">
                      <span class="ab-avatar" aria-hidden="true">{{ $initial }}</span>
                      <span class="ab-author-name">{{ $b->author ?? 'Unknown' }}</span>
                    </span>
                  </td>
                  <td class="ab-col-img" data-label="Image">
                    @if($b->image)
                      <img class="ab-thumb" src="{{ asset('storage/'.$b->image) }}" alt="Blog image">
                    @else
                      <span class="ab-thumb placeholder">—</span>
                    @endif
                  </td>
                  <td data-label="Created">
                    <span class="ab-chip-date">
                      <svg class="ab-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 2v4M17 2v4M3 9h18M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5A2 2 0 0 0 3 7v12a2 2 0 0 0 2 2Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                      </svg>
                      {{ $b->created_at?->format('M d, Y') }}
                    </span>
                  </td>
                  <td class="ab-col-actions" data-label="Actions">
                    <a class="ab-btn ab-btn-sm" href="{{ route('admin.blogs.edit', $b) }}">Edit</a>
                    <form action="{{ route('admin.blogs.destroy', $b) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this blog?')">
                      @csrf @method('DELETE')
                      <button class="ab-btn ab-btn-sm ab-btn-ghost" type="submit">Delete</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
