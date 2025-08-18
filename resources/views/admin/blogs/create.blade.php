@extends('admin.layout')
@section('title','New Blog')

@section('content')
<div class="admin-blog-create"><!-- SCOPE WRAPPER -->
  <style>
    /* Page-scoped tokens (no :root → no leaks) */
    .admin-blog-create{
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

    .admin-blog-create .nb-wrap{ padding: clamp(12px,1.8vw,20px); background: var(--bg); color: var(--text); }
    .admin-blog-create .nb-card{
      background: var(--surface); border:1px solid var(--border); border-radius: var(--radius);
      box-shadow: var(--shadow); padding: clamp(16px,2vw,22px);
    }
    .admin-blog-create .nb-title{ margin:0 0 6px; font-weight:800; letter-spacing:.2px; }
    .admin-blog-create .nb-subtitle{ margin:0 0 16px; color:var(--muted); }

    /* form */
    .admin-blog-create .nb-form{ display:grid; gap:14px; }
    .admin-blog-create .nb-row{ display:grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap:12px; }
    @media (max-width: 860px){ .admin-blog-create .nb-row{ grid-template-columns: 1fr; } }

    .admin-blog-create .nb-field{ display:grid; gap:6px; }
    .admin-blog-create .nb-label{ font-weight:700; font-size:.95rem; }
    .admin-blog-create .nb-hint{ color:var(--muted); font-size:.88rem; }

    .admin-blog-create .nb-input,
    .admin-blog-create .nb-textarea,
    .admin-blog-create .nb-select{
      width:100%; padding:10px 12px; border-radius:12px;
      border:1px solid var(--border); background: var(--surface-2);
      color:var(--text); box-shadow: var(--shadow-sm);
      transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .admin-blog-create .nb-textarea{ min-height:130px; resize:vertical; }
    .admin-blog-create .nb-input:focus,
    .admin-blog-create .nb-textarea:focus,
    .admin-blog-create .nb-select:focus{ outline:3px solid var(--ring); outline-offset:2px; background:#fff; }

    .admin-blog-create .nb-errors{
      border:1px solid #fecaca; background:#fff1f2; color:#7f1d1d;
      padding:12px 14px; border-radius:12px; font-weight:700;
    }
    .admin-blog-create .nb-error{ color:#b91c1c; font-size:.88rem; }

    /* image preview */
    .admin-blog-create .nb-preview-box{
      display:grid; gap:10px; padding:12px; border:1px solid var(--border); border-radius:12px; background:var(--surface-2);
    }
    .admin-blog-create .nb-preview{
      max-width:100%; height:auto; border-radius:12px; border:1px solid var(--border); box-shadow: var(--shadow-sm); object-fit:cover;
    }
    .admin-blog-create .nb-counter{ color:var(--muted); font-size:.86rem; text-align:right; }

    /* actions */
    .admin-blog-create .nb-actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:4px; }
    .admin-blog-create .nb-btn{
      appearance:none; border:1px solid var(--border); border-radius:999px;
      padding:10px 14px; font-weight:700; text-decoration:none; cursor:pointer;
      display:inline-flex; align-items:center; gap:.5rem; transition:.18s ease;
      background:#fff; color:var(--text); box-shadow: var(--shadow-sm);
    }
    .admin-blog-create .nb-btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow); }
    .admin-blog-create .nb-btn:focus-visible{ outline:3px solid var(--ring); outline-offset:2px; }
    .admin-blog-create .nb-btn-primary{ background: var(--primary); color:#fff; border-color:transparent; }
    .admin-blog-create .nb-btn-primary:hover{ background: var(--primary-600); }
    .admin-blog-create .nb-btn-ghost{ background: var(--surface-2); }
  </style>

  <div class="nb-wrap">
    <div class="nb-card">
      <h1 class="nb-title">New Blog</h1>
      <p class="nb-subtitle">Create a new blog post. All fields are required.</p>

      {{-- Validation errors (optional UI) --}}
      @if ($errors->any())
        <div class="nb-errors">Please review the highlighted fields.</div>
      @endif

      <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" class="nb-form">
        @csrf

        <div class="nb-field">
          <label class="nb-label" for="title">Title</label>
          <input id="title" type="text" name="title" required class="nb-input" value="{{ old('title') }}">
          @error('title') <div class="nb-error">{{ $message }}</div> @enderror
        </div>

        <div class="nb-field">
          <label class="nb-label" for="author">Author</label>
          <input id="author" type="text" name="author" required class="nb-input" value="{{ old('author') }}">
          @error('author') <div class="nb-error">{{ $message }}</div> @enderror
        </div>

        <div class="nb-field">
          <label class="nb-label" for="short_description">Short Description</label>
          <textarea id="short_description" name="short_description" rows="3" maxlength="500" required class="nb-textarea" aria-describedby="sd-hint sd-count">{{ old('short_description') }}</textarea>
          <div class="nb-hint" id="sd-hint">Max 500 characters. Shown on listings and previews.</div>
          <div class="nb-counter" id="sd-count">0 / 500</div>
          @error('short_description') <div class="nb-error">{{ $message }}</div> @enderror
        </div>

        <div class="nb-field">
          <label class="nb-label" for="full_content">Full Content</label>
          <textarea id="full_content" name="full_content" rows="10" required class="nb-textarea">{{ old('full_content') }}</textarea>
          @error('full_content') <div class="nb-error">{{ $message }}</div> @enderror
        </div>

        <div class="nb-field">
          <label class="nb-label" for="image">Image (JPG/PNG, ≤ 2MB)</label>
          <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png" required class="nb-input" aria-describedby="img-hint">
          <div class="nb-hint" id="img-hint">Recommended 1200×630 (JPG/PNG). Files over 2MB will be rejected by the server.</div>
          <div class="nb-preview-box" id="previewBox" style="display:none;">
            <strong>Preview:</strong>
            <img id="imgPreview" class="nb-preview" alt="Selected image preview">
          </div>
          @error('image') <div class="nb-error">{{ $message }}</div> @enderror
        </div>

        <div class="nb-actions">
          <button class="nb-btn nb-btn-primary" type="submit">Create</button>
          <a class="nb-btn nb-btn-ghost" href="{{ route('admin.blogs.index') }}">Cancel</a>
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
      const box = document.getElementById('previewBox');
      const preview = document.getElementById('imgPreview');

      if(sd && counter){
        const update = () => counter.textContent = (sd.value.length || 0) + ' / 500';
        sd.addEventListener('input', update); update();
      }

      if(imgInput && box && preview){
        imgInput.addEventListener('change', () => {
          const f = imgInput.files && imgInput.files[0];
          if(!f) { box.style.display = 'none'; return; }
          if(f.size > 2 * 1024 * 1024){ // 2MB
            box.style.display = 'none';
            alert('Selected file exceeds 2MB.');
            imgInput.value = '';
            return;
          }
          const reader = new FileReader();
          reader.onload = e => { preview.src = e.target.result; box.style.display = 'grid'; };
          reader.readAsDataURL(f);
        });
      }
    })();
  </script>
</div>
@endsection
