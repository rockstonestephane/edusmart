<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class SchoolComposer
{
    public function compose(View $view): void
    {
        $logoPath = $this->readEnvValue('SCHOOL_LOGO');

        $view->with([
            'schoolName'      => env('SCHOOL_NAME',            config('school.name')),
            'schoolLogo'      => $logoPath ? 'storage/' . $logoPath : null,
            'schoolPhone'     => env('SCHOOL_PHONE',           config('school.phone')),
            'schoolEmail'     => env('SCHOOL_EMAIL',           config('school.email')),
            'schoolAddress'   => env('SCHOOL_ADDRESS',         config('school.address')),
            'schoolFacebook'  => env('SCHOOL_FACEBOOK',        config('school.social.facebook')),
            'schoolInstagram' => env('SCHOOL_INSTAGRAM',       config('school.social.instagram')),
            'schoolYoutube'   => env('SCHOOL_YOUTUBE',         config('school.social.youtube')),
            'schoolLinkedin'  => env('SCHOOL_LINKEDIN',        config('school.social.linkedin')),
            'schoolWhatsapp'  => env('SCHOOL_WHATSAPP',        config('school.social.whatsapp')),
            'schoolTiktok'    => env('SCHOOL_TIKTOK',          config('school.social.tiktok')),
            'espaceParentUrl' => env('SCHOOL_ESPACE_PARENT_URL', ''),
            'flashInfos'      => $this->getFlashInfos(),
        ]);
    }

    /**
     * Lit directement dans le .env pour éviter le cache Laravel
     */
    private function readEnvValue(string $key): ?string
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) return null;

        $content = file_get_contents($envPath);
        if (preg_match("/^{$key}=(.*)$/m", $content, $matches)) {
            return trim($matches[1], '"\'') ?: null;
        }

        return null;
    }

    private function getFlashInfos(): array
    {
        $jsonPath = public_path('storage/settings/flash_infos.json');
        if (file_exists($jsonPath)) {
            $data = json_decode(file_get_contents($jsonPath), true);
            return is_array($data) ? $data : [];
        }
        return config('school.flash_infos', []);
    }
}