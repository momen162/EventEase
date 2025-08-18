@extends('admin.layout')
@section('title','Edit Blog')

@section('content')
<div class="admin-blog-edit"><!-- SCOPE WRAPPER -->
  <style>
    /* Page-scoped tokens (no :root, so nothing leaks) */
    .admin-blog-edit{
      --bg:#ffffff;
      --surface:#ffffff;
      --surface-2:#f9fafb;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --ring: rgba(37,99,235,.35);

      --primary:#2563eb;
      --primary-600:#1d4ed8;
      --danger:#dc2626;

      --radius:14px;
      --shadow:0 10px 30px rgba(0,0,0,.06);
      --shadow-sm:0 3px 10px rgba(0,0,0,.05);
    }

    .admin-blog-edit .be-wrap{ padding: clamp(12px,1.8vw,20px); background: var(--bg); color: var(--text); }
    .admin-blog-edit .be-card{
      background: var(--surface); border:1px solid var(--border); border-radius: var(--radius);
      box-shadow: var(--shadow); padding: clamp(16px,2vw,22px);
    }
    .admin-blog-edit .be-title{ margin:0 0 6px; font-weight:800; letter-spacing:.2px; }
    .admin-blog-edit .be-subtitle{ margin:0 0 16px; color:var(--muted); }

    /* form */
    .admin-blog-edit .be-form{ display:grid; gap:14px; }
    .admin-blog-edit .be-row{ display:grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap:12px; }
    @media (max-width: 860px){ .admin-blog-edit .be-row{ grid-template-columns: 1fr; } }

    .admin-blog-edit .be-field{ display:grid; gap:6px; }
    .admin-blog-edit .be-label{ font-weight:700; font-size:.95rem; }
    .admin-blog-edit .be-hint{ color:var(--muted); font-size:.88rem; }

    .admin-blog-edit .be-input,
    .admin-blog-edit .be-textarea{
      width:100%; padding:10px 12px; border-radius:12px;
      border:1px solid var(--border); background: var(--surface-2);
      color:var(--text); box-shadow: var(--shadow-sm);
      transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .admin-blog-edit .be-textarea{ min-height:130px; resize:vertical; }
    .admin-blog-edit .be-input:focus,
    .admin-blog-edit .be-textarea:focus{ outline:3px solid var(--ring); outline-offset:2px; background:#fff; }

    /* messages */
    .admin-blog-edit .be-errors{
      border:1px solid #fecaca; background:#fff1f2; color:#7f1d1d;
      padding:12px 14px; border-radius:12px; font-weight:700;
      margin-top: 6px;
    }
    .admin-blog-edit .be-error{ color:#b91c1c; font-size:.88rem; }

    /* image preview */
    .admin-blog-edit .be-preview-wrap{
      display:grid; gap:10px; padding:12px; border:1px solid var(--border);
      border-radius:12px; background: var(--surface-2);
    }
    .admin-blog-edit .be-current{
      max-width:100%; height:auto; border-radius:12px; border:1px solid var(--border);
      box-shadow: var(--shadow-sm); object-fit:cover;
    }
    .admin-blog-edit .be-new-preview{
      max-width:100%; height:auto; border-radius:12px; border:1px solid var(--border);
      box-shadow: var(--shadow-sm); object-fit:cover; display:none;
    }

    /* counters */
    .admin-blog-edit .be-counter{ color:var(--muted); font-size:.86rem; text-align:right; }

    /* actions */
    .admin-blog-edit .be-actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top: 4px; }
    .admin-blog-edit .be-btn{
      appearance:none; border:1px solid var(--border); border-radius:999px;
      padding:10px 14px; font-weight:700; text-decoration:none; cursor:pointer;
      display:inline-flex; align-items:center; gap:.5rem; transition:.18s ease;
      background:#fff; color:var(--text); box-shadow: var(--shadow-sm);
    }
    .admin-blog-edit .be-btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow); }
    .admin-blog-edit .be-btn:focus-visible{ outline:3px solid var(--ring); outline-offset:2px; }
    .admin-blog-edit .be-btn-primary{ background: var(--primary); color:#fff; border-color:transparent; }
    .admin-blog-edit .be-btn-primary:hover{ background: var(--primary-600); }
    .admin-blog-edit .be-btn-ghost{ background: var(--surface-2); }
  </style>

  <div class="be-wrap">
    <div class="be-card">
      <h1 class="be-title">Edit Blog</h1>
      <p class="be-subtitle">Update the post and save your changes.</p>

      {{-- Optional: show validation summary if present --}}
      @if ($errors->any())
        <div class="be-errors">Please review the highlighted fields.</div>
      @endif

      <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data" class="be-form">
        @csrf @method('PUT')

        <div class="be-field">
          <label class="be-label" for="title">Title</label>
          <input id="title" type="text" name="title" value="{{ old('title',$blog->title) }}" required class="be-input">
          @error('title') <div class="be-error">{{ $message }}</div> @enderror
        </div>

        <div class="be-field">
          <label class="be-label" for="author">Author</label>
          <input id="author" type="text" name="author" value="{{ old('author',$blog->author) }}" required class="be-input">
          @error('author') <div class="be-error">{{ $message }}</div> @enderror
        </div>

        <div class="be-field">
          <label class="be-label" for="short_description">Short Description</label>
          <textarea id="short_description" name="short_description" rows="3" required class="be-textarea" maxlength="500" aria-describedby="sd-count">{{ old('short_description',$blog->short_description) }}</textarea>
          <div id="sd-count" class="be-counter">0 / 500</div>
          @error('short_description') <div class="be-error">{{ $message }}</div> @enderror
        </div>

        <div class="be-field">
          <label class="be-label" for="full_content">Full Content</label>
          <textarea id="full_content" name="full_content" rows="10" required class="be-textarea">{{ old('full_content',$blog->full_content) }}</textarea>
          @error('full_content') <div class="be-error">{{ $message }}</div> @enderror
        </div>

        <div class="be-field">
          <span class="be-label">Current Image</span>
          @if($blog->image)
            <div class="be-preview-wrap">
              <img src="{{ asset('storage/'.$blog->image) }}" alt="Current blog image" class="be-current">
            </div>
          @else
            <div class="be-hint">No image uploaded.</div>
          @endif
        </div>

        <div class="be-field">
          <label class="be-label" for="image">Replace Image (optional, JPG/PNG ≤ 2MB)</label>
          <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png" class="be-input" aria-describedby="img-hint">
          <div class="be-hint" id="img-hint">Recommended 1200×630. Larger than 2MB will be rejected.</div>
          <img id="newPreview" class="be-new-preview" alt="New image preview">
          @error('image') <div class="be-error">{{ $message }}</div> @enderror
        </div>

        <div class="be-actions">
          <button class="be-btn be-btn-primary" type="submit">Save Changes</button>
          <a class="be-btn be-btn-ghost" href="{{ route('admin.blogs.index') }}">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Tiny scoped helpers (UI-only) -->
  <script>
    (function(){
      const sd = document.getElementById('short_description');
      const counter = document.getElementById('sd-count');
      const imgInput = document.getElementById('image');
      const preview = document.getElementById('newPreview');

      if(sd && counter){
        const update = () => counter.textContent = (sd.value.length || 0) + ' / 500';
        sd.addEventListener('input', update); update();
      }

      if(imgInput && preview){
        imgInput.addEventListener('change', () => {
          const f = imgInput.files && imgInput.files[0];
          if(!f){ preview.style.display = 'none'; return; }
          if(f.size > 2 * 1024 * 1024){
            preview.style.display = 'none';
            alert('Selected file exceeds 2MB.');
            imgInput.value = '';
            return;
          }
          const reader = new FileReader();
          reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
          reader.readAsDataURL(f);
        });
      }
    })();
  </script>
</div>
@endsection
