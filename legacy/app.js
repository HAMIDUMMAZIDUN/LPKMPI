// LPK-MI JavaScript Application

// 1. Mock Programs Database
const TRAINING_PROGRAMS = [
    {
        id: "mi_prog",
        title: "Pelatihan Kepemimpinan Kepala Madrasah Ibtidaiyah (MI)",
        category: "Kategori Madrasah",
        duration: "40 Jam Pelajaran (JP)",
        description: "Mempersiapkan kompetensi pedagogik, kepribadian, sosial, dan manajerial calon kepala madrasah tingkat Ibtidaiyah sesuai standar kelayakan sertifikasi LSPMI.",
        benefits: ["Sertifikat Pelatihan LPK-MI", "Simulasi Soal Uji Kompetensi", "Bimbingan Portofolio"],
        price: "Rp 1.500.000",
        lspKeyword: "Ibtidaiyah"
    },
    {
        id: "mts_prog",
        title: "Pelatihan Kepemimpinan Kepala Madrasah Tsanawiyah (MTs)",
        category: "Kategori Madrasah",
        duration: "48 Jam Pelajaran (JP)",
        description: "Pelatihan tingkat lanjut bagi guru dan waka madrasah untuk meningkatkan keterampilan manajemen sekolah, supervisi guru, dan kewirausahaan madrasah.",
        benefits: ["Sertifikat Pelatihan LPK-MI", "Akses LMS 30 Hari", "Modul Digital Lengkap"],
        price: "Rp 1.750.000",
        lspKeyword: "Tsanawiyah"
    },
    {
        id: "ma_prog",
        title: "Pelatihan Kepemimpinan Kepala Madrasah Aliyah (MA)",
        category: "Kategori Madrasah",
        duration: "50 Jam Pelajaran (JP)",
        description: "Menghasilkan pemimpin madrasah aliyah yang berdaya saing global, menguasai TI pendidikan, tata kelola kurikulum merdeka, dan standarisasi akreditasi nasional.",
        benefits: ["Sertifikat Pelatihan LPK-MI", "Bimbingan Penyusunan DIT", "Review Portofolio oleh Asesor"],
        price: "Rp 2.000.000",
        lspKeyword: "Aliyah"
    },
    {
        id: "ptki_prog",
        title: "Pelatihan Kepemimpinan Pimpinan Perguruan Tinggi Keagamaan Islam (PTKI)",
        category: "Kategori Pendidikan Tinggi",
        duration: "64 Jam Pelajaran (JP)",
        description: "Dirancang khusus bagi Dosen/Pimpinan PTKI untuk menguasai tata kelola universitas, penjaminan mutu BAN-PT, kepemimpinan transformatif, dan kerja sama akademik.",
        benefits: ["Sertifikat Pelatihan LPK-MI", "Studi Kasus Internasional", "Rekomendasi Akreditasi"],
        price: "Rp 3.500.000",
        lspKeyword: "Perguruan Tinggi"
    }
];

// Sample Seeders Database
const SEED_TRAINEES = [
    {
        name: "Dr. Hamidun, M.Pd",
        nik: "1234567890123456",
        email: "hamidun@gmail.com",
        phone: "081234567890",
        education: "S3",
        category: "mahasiswa",
        company: "Universitas Islam Negeri Sunan Kalijaga",
        position: "Dosen Kepala",
        programId: "ptki_prog",
        certNumber: "LPK-MI-2026-9042",
        certDate: "05 Juli 2026",
        status: "LULUS"
    },
    {
        name: "Siti Rahmawati, S.Pd.I",
        nik: "3201928374820192",
        email: "siti.rahma@madrasah.sch.id",
        phone: "085712345678",
        education: "S1",
        category: "guru",
        company: "MI Al-Hidayah Bandung",
        position: "Waka Kurikulum",
        programId: "mi_prog",
        certNumber: "LPK-MI-2026-1024",
        certDate: "01 Juni 2026",
        status: "LULUS"
    },
    {
        name: "M. Yusuf Al-Farabi, M.Ag",
        nik: "3504829302910394",
        email: "yusuf.farabi@mtsn.sch.id",
        phone: "081398765432",
        education: "S2",
        category: "guru",
        company: "MTs Negeri 1 Yogyakarta",
        position: "Guru Utama",
        programId: "mts_prog",
        certNumber: "LPK-MI-2026-5819",
        certDate: "12 Mei 2026",
        status: "LULUS"
    }
];

// 2. DOM Elements & State Management
const STATE = {
    trainees: JSON.parse(localStorage.getItem('lpk_trainees')) || [],
    apiHits: parseInt(localStorage.getItem('lpk_api_hits')) || 0,
    currentTab: 'beranda'
};

document.addEventListener('DOMContentLoaded', () => {
    initApp();
});

function initApp() {
    setupNavigation();
    renderPrograms();
    populateFormSelect();
    updateAdminView();
    setupForms();
    setupBridgeSimulator();

    // Event listener for CTA Buttons
    document.getElementById('explore-programs-btn').addEventListener('click', () => switchTab('program'));
    document.getElementById('sim-bridge-btn').addEventListener('click', () => switchTab('integrasi-lsp'));
    document.getElementById('cta-register-btn').addEventListener('click', () => switchTab('pendaftaran'));
    document.getElementById('nav-logo-btn').addEventListener('click', (e) => {
        e.preventDefault();
        switchTab('beranda');
    });

    // Seeder data trigger
    document.getElementById('btn-seed-data').addEventListener('click', seedData);
}

// 3. Navigation / Routing SPA
function setupNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetTab = link.getAttribute('data-tab');
            switchTab(targetTab);
        });
    });
}

function switchTab(tabId) {
    STATE.currentTab = tabId;
    
    // Update active tab visual
    document.querySelectorAll('.tab-content').forEach(section => {
        section.classList.remove('active-tab');
    });
    document.getElementById(`sec-${tabId}`).classList.add('active-tab');

    // Update active nav-link
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('data-tab') === tabId) {
            link.classList.add('active');
        }
    });

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// 4. Render Programs list
function renderPrograms() {
    const container = document.getElementById('programs-container');
    if (!container) return;

    container.innerHTML = TRAINING_PROGRAMS.map(prog => {
        return `
            <div class="glass-card program-card" id="card-${prog.id}">
                <div class="prog-meta">
                    <span class="prog-category">${prog.category}</span>
                    <span class="prog-duration"><i class="fa-regular fa-clock"></i> ${prog.duration}</span>
                </div>
                <h3>${prog.title}</h3>
                <p>${prog.description}</p>
                <ul class="prog-benefits">
                    ${prog.benefits.map(b => `<li><i class="fa-solid fa-check"></i> ${b}</li>`).join('')}
                </ul>
                <div class="prog-footer">
                    <div class="prog-price">${prog.price}<span>/Peserta</span></div>
                    <button class="btn btn-primary" onclick="selectProgramAndRegister('${prog.id}')">Daftar Kelas <i class="fa-solid fa-right-to-bracket"></i></button>
                </div>
            </div>
        `;
    }).join('');
}

function selectProgramAndRegister(programId) {
    const select = document.getElementById('enroll-program');
    if (select) {
        select.value = programId;
    }
    switchTab('pendaftaran');
}

// Global scope definition so it can be called from onclick attributes
window.selectProgramAndRegister = selectProgramAndRegister;

// Populate Program options in select inputs
function populateFormSelect() {
    const select = document.getElementById('enroll-program');
    if (!select) return;

    // Clear existing
    select.innerHTML = '<option value="" disabled selected>Pilih Program Pelatihan...</option>';
    TRAINING_PROGRAMS.forEach(prog => {
        const opt = document.createElement('option');
        opt.value = prog.id;
        opt.textContent = prog.title;
        select.appendChild(opt);
    });
}

// 5. Enrollment Form Submission
function setupForms() {
    const form = document.getElementById('enrollment-form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const programId = document.getElementById('enroll-program').value;
        const name = document.getElementById('enroll-name').value;
        const nik = document.getElementById('enroll-nik').value;
        const email = document.getElementById('enroll-email').value;
        const phone = document.getElementById('enroll-phone').value;
        const education = document.getElementById('enroll-education').value;
        const category = document.getElementById('enroll-category').value;
        const company = document.getElementById('enroll-company').value;
        const position = document.getElementById('enroll-position').value;

        // Generate Certificate
        const randNum = Math.floor(1000 + Math.random() * 9000);
        const certNumber = `LPK-MI-${new Date().getFullYear()}-${randNum}`;
        const certDate = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

        const newTrainee = {
            name,
            nik,
            email,
            phone,
            education,
            category,
            company,
            position,
            programId,
            certNumber,
            certDate,
            status: "LULUS"
        };

        // Save to state & storage
        STATE.trainees.unshift(newTrainee);
        localStorage.setItem('lpk_trainees', JSON.stringify(STATE.trainees));

        // Update visual certificate
        document.getElementById('cert-holder-name').textContent = name.toUpperCase();
        
        const selectedProgObj = TRAINING_PROGRAMS.find(p => p.id === programId);
        document.getElementById('cert-program-name').textContent = selectedProgObj ? selectedProgObj.title : 'Program Pelatihan';
        document.getElementById('cert-number-val').textContent = certNumber;
        document.getElementById('cert-date-val').textContent = certDate;

        // Toggle visual form to success card
        form.reset();
        document.querySelector('.enrollment-container').classList.add('hidden');
        
        const successCard = document.getElementById('enrollment-success-card');
        successCard.classList.remove('hidden');

        // Update statistics and admin panel table
        updateAdminView();

        // Bind copy certificate button
        document.getElementById('copy-cert-num-btn').onclick = () => {
            navigator.clipboard.writeText(certNumber);
            alert(`Nomor sertifikat ${certNumber} berhasil disalin!`);
        };

        // Bind bridge test button
        document.getElementById('goto-bridge-btn').onclick = () => {
            document.getElementById('lsp-sim-nik').value = nik;
            document.getElementById('lsp-sim-cert-number').value = certNumber;
            switchTab('integrasi-lsp');
        };

        // Reset enrollment view button
        document.getElementById('reset-enrollment-btn').onclick = () => {
            successCard.classList.add('hidden');
            document.querySelector('.enrollment-container').classList.remove('hidden');
        };
    });
}

// 6. Admin Panel Functions
function updateAdminView() {
    // Stats calculation
    const totalTrainees = STATE.trainees.length;
    const certCount = STATE.trainees.filter(t => t.status === 'LULUS').length;

    document.getElementById('admin-stat-total').textContent = totalTrainees;
    document.getElementById('admin-stat-cert').textContent = certCount;
    document.getElementById('admin-stat-api').textContent = STATE.apiHits;

    // Table render
    const tbody = document.getElementById('admin-trainee-table-body');
    if (!tbody) return;

    if (STATE.trainees.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">Belum ada data pendaftar. Gunakan formulir pendaftaran atau isi data sampel.</td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = STATE.trainees.map(t => {
        const progObj = TRAINING_PROGRAMS.find(p => p.id === t.programId);
        return `
            <tr>
                <td><strong>${t.name}</strong></td>
                <td><code>${t.nik}</code></td>
                <td>${progObj ? progObj.title : 'Program Pelatihan'}</td>
                <td><span class="text-info" style="font-weight: 600;">${t.certNumber}</span></td>
                <td><span class="direction-badge" style="text-transform: uppercase;">${t.category}</span></td>
                <td><span class="status-cell">${t.status}</span></td>
            </tr>
        `;
    }).join('');
}

function seedData() {
    if (confirm("Apakah Anda ingin mengisi data LPK dengan sampel data siap uji?")) {
        // Merge or replace
        STATE.trainees = [...SEED_TRAINEES, ...STATE.trainees];
        // Deduplicate by NIK
        const unique = [];
        const map = new Map();
        for (const item of STATE.trainees) {
            if(!map.has(item.nik)){
                map.set(item.nik, true);
                unique.push(item);
            }
        }
        STATE.trainees = unique;
        localStorage.setItem('lpk_trainees', JSON.stringify(STATE.trainees));
        updateAdminView();
        alert("Sampel data berhasil ditambahkan ke tabel LPK.");
    }
}

// 7. LSP Integration Bridge Simulator
function setupBridgeSimulator() {
    const btnAutofill = document.getElementById('btn-autofill-nik');
    const inputNik = document.getElementById('lsp-sim-nik');
    const inputCert = document.getElementById('lsp-sim-cert-number');
    const btnVerify = document.getElementById('btn-verify-lsp-registration');
    const resultBox = document.getElementById('lsp-verification-result');
    const terminal = document.getElementById('api-terminal-log');

    // Autofill with the first student's NIK and Certificate in the database
    btnAutofill.addEventListener('click', () => {
        if (STATE.trainees.length === 0) {
            logTerminal("WARNING: Tidak ada data di database LPK. Harap isi data sampel di Panel Admin dahulu.", "text-warn");
            alert("Tidak ada data pendaftaran LPK. Isi data sampel terlebih dahulu di tab 'Panel Admin'.");
            return;
        }
        
        // Take first trainee
        const sample = STATE.trainees[0];
        inputNik.value = sample.nik;
        inputCert.value = sample.certNumber;
        logTerminal(`[AUTOFILL] Memasukkan data sampel: Nama = ${sample.name}, NIK = ${sample.nik}`, "text-info");
    });

    btnVerify.addEventListener('click', () => {
        const nik = inputNik.value.trim();
        const certNumber = inputCert.value.trim();

        if (!nik || !certNumber) {
            alert("Harap isi NIK dan Nomor Sertifikat LPK terlebih dahulu.");
            return;
        }

        // Animate API line pulse
        const pulse = document.getElementById('api-pulse-line');
        pulse.classList.add('active');
        logTerminal(`[REQUEST] GET https://lpk-mi.or.id/api/verify-certificate?number=${certNumber}&nik=${nik}`, "text-info");

        // Increment API hits stat
        STATE.apiHits++;
        localStorage.setItem('lpk_api_hits', STATE.apiHits);
        document.getElementById('admin-stat-api').textContent = STATE.apiHits;

        setTimeout(() => {
            pulse.classList.remove('active');

            // Find match
            const match = STATE.trainees.find(t => t.certNumber.toLowerCase() === certNumber.toLowerCase() && t.nik === nik);

            if (match) {
                const progObj = TRAINING_PROGRAMS.find(p => p.id === match.programId);
                
                logTerminal(`[RESPONSE 200 OK] Sertifikat Ditemukan!`, "text-success");
                logTerminal(JSON.stringify({
                    status: "valid",
                    data: {
                        name: match.name,
                        nik: match.nik,
                        program: progObj ? progObj.title : '',
                        certificate_number: match.certNumber,
                        education: match.education,
                        status_kelulusan: match.status
                    }
                }, null, 2), "text-success");

                // Render result view
                resultBox.className = "verification-box valid";
                resultBox.innerHTML = `
                    <div class="result-title valid"><i class="fa-solid fa-circle-check"></i> DATA VALID (Terverifikasi LPK)</div>
                    <div class="result-details">
                        <p style="margin-bottom: 8px;">Dokumen Bukti Pelatihan ini sah diterbitkan oleh LPK-MI. Data peserta otomatis ditarik:</p>
                        <table>
                            <tr><td>Nama Peserta</td><td>: ${match.name}</td></tr>
                            <tr><td>NIK</td><td>: ${match.nik}</td></tr>
                            <tr><td>Pendidikan</td><td>: ${match.education}</td></tr>
                            <tr><td>Program LPK</td><td>: ${progObj ? progObj.title : ''}</td></tr>
                            <tr><td>No. Sertifikat</td><td>: <code>${match.certNumber}</code></td></tr>
                            <tr><td>Status Uji LPK</td><td>: <span class="status-cell">${match.status}</span></td></tr>
                        </table>
                        <div class="integration-notice" style="margin-top: 15px; padding: 10px; background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2)">
                            <i class="fa-solid fa-circle-nodes" style="color: var(--accent);"></i>
                            <p style="color: #a7f3d0; font-size: 11px;"><strong>Fast-track Ready:</strong> Form pendaftaran di website LSPMI sekarang dapat di-autofill sepenuhnya menggunakan data di atas.</p>
                        </div>
                    </div>
                `;
            } else {
                logTerminal(`[RESPONSE 404 NOT FOUND] Data sertifikasi atau NIK tidak sesuai.`, "text-warn");
                logTerminal(JSON.stringify({
                    status: "invalid",
                    message: "Sertifikat tidak terdaftar atau NIK peserta tidak cocok dengan database LPK-MI."
                }, null, 2), "text-warn");

                // Render result view
                resultBox.className = "verification-box invalid";
                resultBox.innerHTML = `
                    <div class="result-title invalid"><i class="fa-solid fa-circle-xmark"></i> DATA TIDAK VALID</div>
                    <div class="result-details">
                        <p>Nomor sertifikat <strong>"${certNumber}"</strong> tidak terdaftar untuk NIK <strong>"${nik}"</strong> pada database LPK-MI.</p>
                        <p style="margin-top: 8px; font-size: 11px;" class="text-warn">💡 Pastikan NIK yang Anda masukkan di form LSP sama dengan NIK saat mendaftar di LPK.</p>
                    </div>
                `;
            }

            resultBox.classList.remove('hidden');
        }, 1200); // 1.2s fake latency for realistic API feel
    });
}

function logTerminal(message, className = "") {
    const terminal = document.getElementById('api-terminal-log');
    if (!terminal) return;

    // Check if placeholder is present and clear it
    if (terminal.innerHTML.includes("// Konsol siap")) {
        terminal.innerHTML = "";
    }

    const timestamp = new Date().toLocaleTimeString();
    const line = document.createElement('span');
    line.className = `log-line ${className}`;
    
    // Format json nicely if needed
    if (message.startsWith('{') || message.startsWith('[')) {
        line.innerHTML = `[${timestamp}] <pre style="font-family:inherit; margin-top:5px; white-space:pre-wrap;">${message}</pre>`;
    } else {
        line.innerHTML = `[${timestamp}] ${message}`;
    }

    terminal.appendChild(line);
    terminal.scrollTop = terminal.scrollHeight;
}
