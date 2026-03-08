{{--
╔══════════════════════════════════════════════════════════════════════╗
║  EDU SMART SCHOOL V2 — Footer Component                              ║
║  resources/views/frontend/components/footer.blade.php                ║
║  Usage dans le layout : @include('frontend.components.footer')       ║
╚══════════════════════════════════════════════════════════════════════╝
--}}

<style>
:root {
    --footer-bg-deep:   #07090f;
    --footer-bg-mid:    #0d1224;
    --footer-bg-card:   #131830;
    --footer-border:    rgba(255,255,255,0.06);
    --footer-gold:      #f5c842;
    --footer-gold-dim:  rgba(245,200,66,0.18);
    --footer-blue:      #2952f5;
    --footer-text:      rgba(255,255,255,0.55);
    --footer-text-hi:   rgba(255,255,255,0.85);
}
.edu-footer {
    position: relative;
    background: var(--footer-bg-deep);
    overflow: hidden;
    font-family: 'DM Sans', sans-serif;
}
.edu-footer::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 0;
    opacity: 0.4;
}
.footer-geo-bg { position: absolute; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
.footer-geo-bg::before {
    content: '';
    position: absolute;
    top: -120px; right: -120px;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(41,82,245,0.08) 0%, transparent 70%);
}
.footer-geo-bg::after {
    content: '';
    position: absolute;
    bottom: 60px; left: -80px;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,200,66,0.05) 0%, transparent 70%);
}
.footer-hero {
    position: relative; z-index: 1;
    padding: 72px 0 64px;
    border-bottom: 1px solid var(--footer-border);
    text-align: center;
}
.footer-watermark {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    font-family: 'Playfair Display', serif;
    font-size: clamp(80px, 14vw, 180px);
    font-weight: 900;
    white-space: nowrap;
    color: transparent;
    -webkit-text-stroke: 1px rgba(255,255,255,0.04);
    pointer-events: none;
    user-select: none;
    letter-spacing: -0.04em;
    line-height: 1;
}
.footer-cta-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--footer-gold);
    margin-bottom: 20px;
}
.footer-cta-label span { display: inline-block; width: 28px; height: 1px; background: var(--footer-gold); opacity: 0.5; }
.footer-hero h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 4vw, 3.2rem);
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
    margin: 0 auto 28px;
    max-width: 680px;
}
.footer-hero h2 em {
    font-style: italic;
    background: linear-gradient(135deg, #f5c842, #e8b014);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.footer-hero-btns { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 14px; }
.btn-footer-primary {
    display: inline-flex; align-items: center; gap: 9px;
    padding: 13px 28px;
    background: linear-gradient(135deg, #f5c842, #e8b014);
    color: #0d1224;
    font-family: 'DM Sans', sans-serif; font-size: 0.85rem; font-weight: 800;
    border-radius: 12px; text-decoration: none; letter-spacing: 0.02em;
    box-shadow: 0 8px 32px rgba(245,200,66,0.35);
    transition: transform 0.25s, box-shadow 0.25s, background 0.2s;
}
.btn-footer-primary:hover { transform: translateY(-3px); box-shadow: 0 14px 40px rgba(245,200,66,0.5); background: linear-gradient(135deg, #ffe066, #f5c842); }
.btn-footer-outline {
    display: inline-flex; align-items: center; gap: 9px;
    padding: 12px 26px;
    background: transparent; color: rgba(255,255,255,0.8);
    font-family: 'DM Sans', sans-serif; font-size: 0.85rem; font-weight: 600;
    border-radius: 12px; border: 1.5px solid rgba(255,255,255,0.2); text-decoration: none;
    transition: border-color 0.2s, color 0.2s, transform 0.25s, background 0.2s;
}
.btn-footer-outline:hover { border-color: rgba(255,255,255,0.5); color: #fff; background: rgba(255,255,255,0.06); transform: translateY(-3px); }
.footer-body { position: relative; z-index: 1; padding: 64px 0 56px; border-bottom: 1px solid var(--footer-border); }
.footer-grid { display: grid !important; grid-template-columns: 1.4fr 1fr 1fr 1.3fr !important; gap: 48px; min-width: 0; }
.footer-brand-logo { display: flex !important; align-items: center; gap: 12px; text-decoration: none; margin-bottom: 20px; }
.footer-logo-icon {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, #f5c842, #e8b014);
    border-radius: 14px; display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(245,200,66,0.3); flex-shrink: 0; transition: transform 0.3s; overflow: hidden;
}
.footer-brand-logo:hover .footer-logo-icon { transform: rotate(-6deg) scale(1.08); }
.footer-logo-name { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.1rem; color: #fff; line-height: 1.1; }
.footer-logo-sub { font-size: 0.68rem; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase; color: var(--footer-gold); margin-top: 3px; display: block; }
.footer-brand-desc { font-size: 0.84rem; line-height: 1.75; color: var(--footer-text); margin-bottom: 24px; }
.footer-accreditations { display: flex !important; flex-wrap: wrap; gap: 8px; margin-bottom: 24px; }
.accred-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; background: var(--footer-bg-card); border: 1px solid var(--footer-border); border-radius: 8px; font-size: 0.7rem; font-weight: 600; color: var(--footer-text); letter-spacing: 0.04em; }
.accred-badge .dot { width: 6px; height: 6px; background: #22c55e; border-radius: 50%; flex-shrink: 0; box-shadow: 0 0 6px rgba(34,197,94,0.6); }
.footer-socials { display: flex !important; gap: 8px; flex-wrap: wrap; }
.footer-social-btn { width: 36px; height: 36px; background: var(--footer-bg-card); border: 1px solid var(--footer-border); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--footer-text); text-decoration: none; transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.2s; }
.footer-social-btn:hover { background: var(--footer-blue); border-color: var(--footer-blue); color: #fff; transform: translateY(-3px); }
.footer-social-btn.yt:hover { background: #ef4444; border-color: #ef4444; }
.footer-social-btn.fb:hover { background: #1877f2; border-color: #1877f2; }
.footer-social-btn.ig:hover { background: linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); border-color: #e6683c; }
.footer-social-btn.tw:hover { background: #000; border-color: #555; }
.footer-social-btn.li:hover { background: #0a66c2; border-color: #0a66c2; }
.footer-social-btn.wa:hover { background: #25d366; border-color: #25d366; }
.footer-col-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 0.95rem; color: #fff; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--footer-border); position: relative; }
.footer-col-title::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 32px; height: 2px; background: var(--footer-gold); border-radius: 2px; }
.footer-nav-list { list-style: none; margin: 0; padding: 0; display: flex !important; flex-direction: column; gap: 2px; }
.footer-nav-list li a { display: flex; align-items: center; gap: 10px; padding: 6px 0; font-size: 0.84rem; color: var(--footer-text); text-decoration: none; transition: color 0.2s, gap 0.2s; }
.footer-nav-list li a:hover { color: var(--footer-gold); gap: 14px; }
.footer-nav-list li a .arrow { width: 14px; height: 14px; opacity: 0.4; flex-shrink: 0; transition: opacity 0.2s, transform 0.2s; }
.footer-nav-list li a:hover .arrow { opacity: 1; transform: translateX(3px); }
.footer-contact-card { background: var(--footer-bg-card); border: 1px solid var(--footer-border); border-radius: 16px; overflow: hidden; display: flex !important; flex-direction: column !important; }
.footer-contact-card-header { background: linear-gradient(135deg, #1a3de8, #152dd4); padding: 16px 20px; display: flex !important; align-items: center; gap: 10px; }
.footer-contact-card-header span { font-family: 'DM Sans', sans-serif; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.9); }
.footer-contact-items { padding: 16px 20px; display: flex !important; flex-direction: column !important; gap: 14px; }
.footer-contact-item { display: flex !important; align-items: flex-start !important; gap: 12px; }
.contact-icon-wrap { width: 32px; height: 32px; background: rgba(41,82,245,0.15); border: 1px solid rgba(41,82,245,0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #7ba3ff; }
.footer-contact-item .info-label { font-size: 0.68rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--footer-gold); line-height: 1; margin-bottom: 3px; }
.footer-contact-item .info-val { font-size: 0.82rem; color: var(--footer-text-hi); line-height: 1.4; }
.footer-contact-item .info-val a { color: inherit; text-decoration: none; transition: color 0.2s; }
.footer-contact-item .info-val a:hover { color: var(--footer-gold); }
.hours-badge { display: inline-flex !important; align-items: center !important; gap: 6px; padding: 6px 14px; margin: 0 20px 16px; background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); border-radius: 8px; font-size: 0.74rem; font-weight: 600; color: #86efac; }
.hours-badge .pulse { width: 7px; height: 7px; background: #22c55e; border-radius: 50%; animation: pulse-dot 2s ease-in-out infinite; flex-shrink: 0; }
@keyframes pulse-dot { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.8); } }
.footer-newsletter { background: var(--footer-bg-card); border: 1px solid var(--footer-border); border-radius: 16px; padding: 20px; margin-top: 20px; }
.footer-newsletter p { font-size: 0.8rem; color: var(--footer-text); margin-bottom: 12px; line-height: 1.5; }
.footer-newsletter p strong { color: #fff; display: block; font-size: 0.88rem; margin-bottom: 4px; }
.newsletter-form { display: flex !important; gap: 8px; }
.newsletter-form input { flex: 1; min-width: 0; background: rgba(255,255,255,0.07); border: 1px solid var(--footer-border); border-radius: 10px; padding: 10px 14px; font-size: 0.82rem; color: #fff; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color 0.2s, background 0.2s; }
.newsletter-form input::placeholder { color: rgba(255,255,255,0.3); }
.newsletter-form input:focus { border-color: rgba(41,82,245,0.6); background: rgba(255,255,255,0.1); }
.newsletter-form button { padding: 10px 18px; background: var(--footer-gold); color: #0d1224; font-family: 'DM Sans', sans-serif; font-size: 0.8rem; font-weight: 800; border: none; border-radius: 10px; cursor: pointer; white-space: nowrap; flex-shrink: 0; transition: background 0.2s, transform 0.2s; }
.newsletter-form button:hover { background: #ffe066; transform: translateY(-2px); }
.footer-stats-bar { position: relative; z-index: 1; padding: 32px 0; border-bottom: 1px solid var(--footer-border); background: linear-gradient(90deg, rgba(41,82,245,0.06) 0%, transparent 50%, rgba(245,200,66,0.04) 100%); }
.footer-stats-grid { display: grid !important; grid-template-columns: repeat(4, 1fr) !important; gap: 0; }
.footer-stat { text-align: center; padding: 8px 16px; border-right: 1px solid var(--footer-border); }
.footer-stat:last-child { border-right: none; }
.footer-stat-num { font-family: 'Playfair Display', serif; font-size: 1.9rem; font-weight: 700; color: var(--footer-gold); line-height: 1; margin-bottom: 4px; }
.footer-stat-label { font-size: 0.74rem; font-weight: 500; color: var(--footer-text); letter-spacing: 0.04em; }
.footer-bottom { position: relative; z-index: 1; padding: 22px 0; }
.footer-bottom-pattern { position: absolute; inset: 0; background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 24px 24px; pointer-events: none; }
.footer-bottom-inner { position: relative; display: flex !important; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
.footer-copyright { font-size: 0.78rem; color: var(--footer-text); }
.footer-copyright strong { color: var(--footer-gold); font-weight: 700; }
.footer-legal-links { display: flex !important; align-items: center; gap: 4px; flex-wrap: wrap; }
.footer-legal-links a { font-size: 0.75rem; color: rgba(255,255,255,0.3); text-decoration: none; padding: 4px 10px; border-radius: 6px; transition: color 0.2s, background 0.2s; }
.footer-legal-links a:hover { color: rgba(255,255,255,0.7); background: rgba(255,255,255,0.06); }
.footer-legal-links .sep { width: 3px; height: 3px; background: rgba(255,255,255,0.15); border-radius: 50%; }
.footer-made-by { font-size: 0.75rem; color: rgba(255,255,255,0.25); display: flex !important; align-items: center; gap: 6px; }
.footer-made-by strong { color: var(--footer-gold); font-weight: 700; }
@media (max-width: 1024px) { .footer-grid { grid-template-columns: 1fr 1fr !important; gap: 40px; } }
@media (max-width: 768px) { .footer-hero { padding: 52px 0 48px; } .footer-hero-btns { flex-direction: column; align-items: center; } .footer-bottom-inner { flex-direction: column; align-items: center; text-align: center; } .footer-stats-bar { padding: 24px 0; } }
@media (max-width: 640px) { .footer-grid { grid-template-columns: 1fr !important; gap: 36px; } .footer-stats-grid { grid-template-columns: repeat(2, 1fr) !important; } }
</style>

<footer class="edu-footer" role="contentinfo">
    <div class="footer-geo-bg"></div>

    {{-- ══ BLOC HÉRO ══ --}}
    <div class="footer-hero">
        <div class="footer-watermark" aria-hidden="true">Excellence</div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="footer-cta-label" data-aos="fade-down">
                <span></span>
                {{ __('navigation.accueil') === 'Home' ? 'Join our community' : 'Rejoignez notre communauté' }}
                <span></span>
            </div>
            <h2 data-aos="fade-up" data-aos-delay="80">
                @if(app()->getLocale() === 'en')
                    Give your child<br>the education they <em>truly deserve</em>
                @else
                    Offrez à votre enfant<br>l'éducation qu'il <em>mérite vraiment</em>
                @endif
            </h2>
            <div class="footer-hero-btns" data-aos="fade-up" data-aos-delay="160">
                <a href="{{ lroute('preinscription') }}" class="btn-footer-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    {{ __('common.btn_deposer') }}
                </a>
                <a href="{{ lroute('about') }}" class="btn-footer-outline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ app()->getLocale() === 'en' ? 'Learn more about our school' : "En savoir plus sur l'école" }}
                </a>
            </div>
        </div>
    </div>

    {{-- ══ STATS BAR ══ --}}
    <div class="footer-stats-bar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="footer-stats-grid">
                @if(isset($statistiques) && $statistiques->count())
                    @foreach($statistiques as $stat)
                    <div class="footer-stat" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        @if($stat->icone)
                            <div class="text-3xl mb-2" aria-hidden="true">{{ $stat->icone }}</div>
                        @endif
                        <div class="footer-stat-num">{{ $stat->valeur }}{{ $stat->suffixe }}</div>
                        <div class="footer-stat-label">{{ $stat->label }}</div>
                    </div>
                    @endforeach
                @else
                    @foreach([
                        ['2 500+', __('common.eleves')],
                        ['98 %',   __('common.taux_reussite')],
                        ['120+',   __('common.enseignants')],
                        ['35 ans', __('common.annees_experience')],
                    ] as [$num, $label])
                    <div class="footer-stat" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="footer-stat-num">{{ $num }}</div>
                        <div class="footer-stat-label">{{ $label }}</div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ══ CORPS — 4 colonnes ══ --}}
    <div class="footer-body">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="footer-grid">

                {{-- Col 1 : Identité --}}
                <div data-aos="fade-up">
                    <a href="{{ lroute('home') }}" class="footer-brand-logo">
                        @php $logoPath = env('SCHOOL_LOGO', ''); @endphp
                        <div class="footer-logo-icon" style="@if($logoPath) background:transparent;box-shadow:none; @endif">
                            @if($logoPath)
                                <img src="{{ asset('storage/' . $logoPath) }}"
                                 alt="{{ env('SCHOOL_NAME', config('school.name', 'EduSmart')) }}"
                                 loading="lazy"
                                 class="w-full h-full object-contain p-1">
                            @else
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                     stroke="#0d1224" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <div class="footer-logo-name">{{ env('SCHOOL_NAME', config('school.name', 'EduSmart')) }}</div>
                            <span class="footer-logo-sub">{{ env('SCHOOL_SLOGAN', config('school.slogan', 'School of Excellence')) }}</span>
                        </div>
                    </a>

                    <p class="footer-brand-desc">
    {{ app()->getLocale() === 'en'
        ? env('SCHOOL_DESC_EN', 'Private primary technology school founded in 1989.')
        : env('SCHOOL_DESC_FR', 'École privée primaire technologique fondée en 1989.') }}
</p>

                    <div class="footer-accreditations">
                        <span class="accred-badge"><span class="dot"></span></span>
                        <span class="accred-badge"><span class="dot"></span>ISO 9001</span>
                        <span class="accred-badge"><span class="dot"></span>{{ app()->getLocale() === 'en' ? 'Bilingual' : 'Bilingue' }}</span>
                    </div>

                    <div class="footer-socials">
                        <a href="{{ env('SCHOOL_FACEBOOK', config('school.social.facebook', '#')) }}" target="_blank" rel="noopener" class="footer-social-btn fb" aria-label="Facebook">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <a href="{{ env('SCHOOL_INSTAGRAM', config('school.social.instagram', '#')) }}" target="_blank" rel="noopener" class="footer-social-btn ig" aria-label="Instagram">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"/></svg>
                        </a>
                        <a href="{{ env('SCHOOL_TWITTER', config('school.social.twitter', '#')) }}" target="_blank" rel="noopener" class="footer-social-btn tw" aria-label="Twitter / X">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                        </a>
                        <a href="{{ env('SCHOOL_LINKEDIN', config('school.social.linkedin', '#')) }}" target="_blank" rel="noopener" class="footer-social-btn li" aria-label="LinkedIn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                        <a href="{{ env('SCHOOL_YOUTUBE', config('school.social.youtube', '#')) }}" target="_blank" rel="noopener" class="footer-social-btn yt" aria-label="YouTube">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
                        </a>
                        @if(env('SCHOOL_WHATSAPP'))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', env('SCHOOL_WHATSAPP')) }}" target="_blank" rel="noopener" class="footer-social-btn wa" aria-label="WhatsApp">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.117.549 4.107 1.509 5.843L.057 23.428a.75.75 0 00.921.921l5.585-1.452A11.942 11.942 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.725 9.725 0 01-4.964-1.359l-.355-.212-3.686.958.977-3.578-.232-.368A9.725 9.725 0 012.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>{{-- /col 1 --}}

                {{-- Col 2 : Navigation --}}
                <div data-aos="fade-up" data-aos-delay="80">
                    <h4 class="footer-col-title">{{ __('navigation.navigation') }}</h4>
                    <ul class="footer-nav-list">
                        @foreach([
                            [__('navigation.accueil'),    lroute('home')],
                            [__('navigation.a_propos'),   lroute('about')],
                            [__('navigation.formations'), lroute('formations')],
                            [__('navigation.actualites'), lroute('actualites')],
                            [__('navigation.galerie'),    lroute('galerie')],
                            [__('navigation.contact'),    lroute('contact')],
                            [__('navigation.preinscription'), lroute('preinscription')],
                        ] as [$label, $href])
                        <li>
                            <a href="{{ $href }}">
                                <svg class="arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>{{-- /col 2 --}}

                {{-- Col 3 : Infos pratiques --}}
                <div data-aos="fade-up" data-aos-delay="120">
                    <h4 class="footer-col-title">{{ __('navigation.infos_pratiques') }}</h4>
                    <ul class="footer-nav-list">
                        @foreach([
                            [__('navigation.qui_peut_inscrire'), lroute('home')],
                            [__('navigation.calendrier'),        lroute('home')],
                            [__('navigation.manuels'),           lroute('home')],
                            [__('navigation.fournitures'),       lroute('home')],
                            [__('navigation.evenements'),        lroute('home')],
                            [__('navigation.scolarite_frais'),   lroute('home')],
                            [__('common.espace_parent'),         config('school.espace_parent_url','#')],
                        ] as [$label, $href])
                        <li>
                            <a href="{{ $href }}">
                                <svg class="arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>{{-- /col 3 --}}

                {{-- Col 4 : Contact + Newsletter --}}
                <div data-aos="fade-up" data-aos-delay="160">
                    <h4 class="footer-col-title">{{ __('navigation.nous_trouver') }}</h4>

                    <div class="footer-contact-card">
                        <div class="footer-contact-card-header">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.8)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span>{{ __('navigation.coordonnees') }}</span>
                        </div>

                        <div class="hours-badge">
                            <span class="pulse"></span>
                            {{ __('navigation.ouvert') }} · {{ env('SCHOOL_HOURS', config('school.hours.label', 'Lun–Ven 7h30–17h30')) }}
                        </div>

                        <div class="footer-contact-items">
                            <div class="footer-contact-item">
                                <div class="contact-icon-wrap">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div>
                                    <div class="info-label">{{ __('navigation.adresse') }}</div>
                                    <div class="info-val">{{ env('SCHOOL_ADDRESS', config('school.address', 'Yaoundé, Cameroun')) }}</div>
                                </div>
                            </div>
                            <div class="footer-contact-item">
                                <div class="contact-icon-wrap">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.01 1.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                                </div>
                                <div>
                                    <div class="info-label">{{ __('navigation.telephone') }}</div>
                                    <div class="info-val">
                                        <a href="tel:{{ env('SCHOOL_PHONE', config('school.phone', '+237222000000')) }}">
                                            {{ env('SCHOOL_PHONE', config('school.phone', '+237 222 00 00 00')) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-contact-item">
                                <div class="contact-icon-wrap">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </div>
                                <div>
                                    <div class="info-label">{{ __('navigation.email') }}</div>
                                    <div class="info-val">
                                        <a href="mailto:{{ env('SCHOOL_EMAIL', config('school.email', 'contact@edusmart.cm')) }}">
                                            {{ env('SCHOOL_EMAIL', config('school.email', 'contact@edusmart.cm')) }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>{{-- /footer-contact-card --}}

                    <div class="footer-newsletter">
                        <p>
                            <strong>📬 {{ __('common.newsletter_titre') }}</strong>
                            {{ __('common.newsletter_desc') }}
                        </p>

                        @if(session('newsletter_success'))
                            <div id="newsletter-message" style="color:#22c55e;margin-bottom:8px;font-size:0.875rem;">
                                ✅ {{ session('newsletter_success') }}
                            </div>
                        @endif
                        @if(session('newsletter_info'))
                            <div id="newsletter-message" style="color:#f59e0b;margin-bottom:8px;font-size:0.875rem;">
                                ℹ️ {{ session('newsletter_info') }}
                            </div>
                        @endif
                        @if($errors->has('email'))
                            <div style="color:#ef4444;margin-bottom:8px;font-size:0.875rem;">
                                ❌ {{ $errors->first('email') }}
                            </div>
                        @endif

                        <form action="{{ lroute('newsletter.subscribe') }}" method="POST" class="newsletter-form">
                            @csrf
                            <input type="email" name="email"
                                   placeholder="{{ __('common.newsletter_placeholder') }}"
                                   required autocomplete="email">
                            <button type="submit">{{ __('common.btn_abonner') }}</button>
                        </form>
                    </div>

                </div>{{-- /col 4 --}}

            </div>{{-- /footer-grid --}}
        </div>
    </div>{{-- /footer-body --}}

    {{-- ══ BARRE BASSE ══ --}}
    <div class="footer-bottom">
        <div class="footer-bottom-pattern" aria-hidden="true"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">
                    © {{ date('Y') }} <strong>{{ env('SCHOOL_NAME', config('school.name', 'EduSmart School')) }}</strong>.
                    {{ __('navigation.droits_reserves') }}
                </p>
                <div class="footer-legal-links">
                    @foreach([
                        [__('navigation.mentions_legales'),   '#mentions-legales'],
                        [__('navigation.confidentialite'),    '#confidentialite'],
                        [__('navigation.cgu'),                '#cgu'],
                        [__('navigation.plan_site'),          '#sitemap'],
                    ] as [$label, $href])
                    <a href="{{ $href }}">{{ $label }}</a>
                    <span class="sep" aria-hidden="true"></span>
                    @endforeach
                </div>
                <div class="footer-made-by">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
                    </svg>
                    {{ __('navigation.propulse_par') }} <strong>EduSmart V2</strong>
                </div>
            </div>
        </div>
    </div>

    @if(session('newsletter_success') || session('newsletter_info'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const msg = document.getElementById('newsletter-message');
            if (msg) {
                msg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(function () {
                    msg.style.transition = 'opacity 0.5s ease';
                    msg.style.opacity = '0';
                    setTimeout(function () { msg.style.display = 'none'; }, 500);
                }, 5000);
            }
        });
    </script>
    @endif

</footer>