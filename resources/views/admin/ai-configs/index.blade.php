@extends('admin.settings.layout')

@section('settings-content')
<div class="containe">
    <form id="ai-config-form">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle border rounded">
                    <thead class="table-dark text-white">
                        <tr>
                            <th style="width: 25%">🔑 Key</th>
                            <th style="width: 75%">💡 Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($configs as $config)
                        <tr>
                            <td class="fw-bold text-primary">
                                {{ $config->name ?? $config->key }}
                            </td>
                            <td>
                                {{-- Model chọn dropdown --}}
                                @if($config->key === 'ai_model')
                                <select name="configs[{{ $config->id }}]" class="form-select shadow-sm">
                                    <optgroup label="GPT-5 series (mới nhất)">
                                        <option value="gpt-5" @selected($config->value == 'gpt-5')>
                                            GPT-5 – flagship mới nhất, reasoning mạnh (0.01$/1k tokens)
                                        </option>
                                        <option value="gpt-5-mini" @selected($config->value == 'gpt-5-mini')>
                                            GPT-5 mini – rẻ & nhanh (0.002$/1k tokens)
                                        </option>
                                    </optgroup>

                                    <optgroup label="GPT-4.1 series">
                                        <option value="gpt-4.1" @selected($config->value == 'gpt-4.1')>
                                            GPT-4.1 – đa năng, mạnh về code (0.008$/1k tokens)
                                        </option>
                                        <option value="gpt-4.1-mini" @selected($config->value == 'gpt-4.1-mini')>
                                            GPT-4.1 mini – nhẹ, giá rẻ (0.0015$/1k tokens)
                                        </option>
                                    </optgroup>

                                    <optgroup label="GPT-4o series (multimodal)">
                                        <option value="gpt-4o" @selected($config->value == 'gpt-4o')>
                                            GPT-4o – xử lý text, hình ảnh, audio (0.005$/1k tokens)
                                        </option>
                                        <option value="gpt-4o-mini" @selected($config->value == 'gpt-4o-mini')>
                                            GPT-4o mini – nhanh, tiết kiệm chi phí (0.001$/1k tokens)
                                        </option>
                                    </optgroup>

                                    <optgroup label="Reasoning models">
                                        <option value="o3" @selected($config->value == 'o3')>
                                            o3 – reasoning nâng cao (0.02$/1k tokens)
                                        </option>
                                        <option value="o3-mini" @selected($config->value == 'o3-mini')>
                                            o3 mini – reasoning giá rẻ (0.003$/1k tokens)
                                        </option>
                                        <option value="o3-pro" @selected($config->value == 'o3-pro')>
                                            o3 pro – reasoning cao cấp (0.03$/1k tokens)
                                        </option>
                                        <option value="o4-mini" @selected($config->value == 'o4-mini')>
                                            o4 mini – model reasoning mới (0.004$/1k tokens)
                                        </option>
                                    </optgroup>

                                    <optgroup label="Legacy">
                                        <option value="gpt-3.5-turbo" @selected($config->value == 'gpt-3.5-turbo')>
                                            GPT-3.5 Turbo – model cũ, rẻ nhất (0.0005$/1k tokens)
                                        </option>
                                    </optgroup>
                                </select>
                                <small class="text-muted">⚠️ 1k token khoảng 600-700 từ</small>



                                {{-- Blacklist: Tagify --}}
                                @elseif($config->key === 'ai_blacklist')
                                <input id="ai_blacklist" name="configs[{{ $config->id }}]" value='{{ $config->value }}'>
                                <small class="text-muted">⚠️ Nhập từ → Enter để thêm tag</small>

                                {{-- Prompt AI: CodeMirror --}}
                                @elseif($config->key === 'ai_prompt')
                                <textarea id="ai_prompt_editor"
                                    name="configs[{{ $config->id }}]" hidden>{{ $config->value }}</textarea>
                                <div id="editor-container" class="border rounded" style="height:300px;"></div>

                                {{-- Placeholder --}}
                                <div class="mt-4">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-stars text-danger"></i> Placeholder khả dụng:
                                    </label>
                                    <div class="row row-cols-2 row-cols-md-3 g-3">

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-type-bold text-primary fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{title}}</code>
                                                        <div class="small text-muted">Tiêu đề công việc</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-file-earmark-text text-success fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{description}}</code>
                                                        <div class="small text-muted">Mô tả chi tiết</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-list-check text-warning fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{requirements}}</code>
                                                        <div class="small text-muted">Yêu cầu</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-gift text-info fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{benefits}}</code>
                                                        <div class="small text-muted">Quyền lợi</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-cash-stack text-danger fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{salary_min}}</code>
                                                        <div class="small text-muted">Lương tối thiểu</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-cash text-danger fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{salary_max}}</code>
                                                        <div class="small text-muted">Lương tối đa</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-currency-exchange text-secondary fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{currency}}</code>
                                                        <div class="small text-muted">Loại tiền tệ</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-briefcase-fill text-dark fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{job_type}}</code>
                                                        <div class="small text-muted">Loại công việc</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-mortarboard text-purple fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{experience}}</code>
                                                        <div class="small text-muted">Kinh nghiệm</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                                <div class="card-body py-2 px-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-translate text-info fs-5"></i>
                                                    <div>
                                                        <code class="fw-bold">@{{jobLanguage}}</code>
                                                        <div class="small text-muted">Ngôn ngữ</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                {{-- Default text input --}}
                                @else
                                <input type="text" name="configs[{{ $config->id }}]"
                                    value="{{ $config->value }}" class="form-control shadow-sm" />
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">
                                🚫 Chưa có cấu hình nào.<br>
                                <small>Hãy chạy seeder hoặc thêm thủ công trong DB.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4">
                <button type="button" id="btn-save-all" class="btn btn-lg btn-success shadow-sm px-4">
                    💾 Lưu tất cả
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@section('scripts')
{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Tagify --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.17.9/tagify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.17.9/tagify.css" />

{{-- CodeMirror --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/mode/javascript/javascript.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.13/codemirror.min.css" />

<script>
    // Tagify cho Blacklist
    const blacklistInput = document.querySelector('#ai_blacklist');
    if (blacklistInput) {
        new Tagify(blacklistInput, {
            delimiters: ",",
            dropdown: {
                enabled: 0
            }
        });
    }

    // CodeMirror cho Prompt
    let editor;
    const promptTextarea = document.getElementById("ai_prompt_editor");
    if (promptTextarea) {
        editor = CodeMirror(document.getElementById("editor-container"), {
            value: promptTextarea.value,
            mode: "javascript",
            theme: "default",
            lineNumbers: true,
            tabSize: 2
        });
    }

    // Lưu toàn bộ
    document.getElementById('btn-save-all').addEventListener('click', function() {
        if (editor) {
            promptTextarea.value = editor.getValue();
        }

        let form = document.getElementById('ai-config-form');
        let formData = new FormData(form);

        let configs = {};
        for (let [key, value] of formData.entries()) {
            let id = key.match(/configs\[(\d+)\]/)[1];
            configs[id] = value;
        }

        fetch("{{ secure_url(route('admin.ai-configs.updateAll', [], false)) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    configs: configs
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: data.message,
                        confirmButtonColor: '#198754'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi khi lưu',
                    });
                }
            })
            .catch(err => Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: err,
            }));
    });
</script>
@endsection