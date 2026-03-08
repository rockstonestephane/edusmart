<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.parametres.index');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'school_name'        => 'required|string|max:100',
            'school_slogan'      => 'nullable|string|max:150',
            'school_description' => 'nullable|string|max:500',
            'school_address'     => 'nullable|string|max:200',
            'school_phone'       => 'nullable|string|max:30',
            'school_phone2'      => 'nullable|string|max:30',
            'school_email'       => 'nullable|email|max:100',
            'school_website'     => 'nullable|string|max:100',
            'school_hours'       => 'nullable|string|max:100',
            'school_facebook'    => 'nullable|string|max:200',
            'school_instagram'   => 'nullable|string|max:200',
            'school_twitter'     => 'nullable|string|max:200',
            'school_linkedin'    => 'nullable|string|max:200',
            'school_youtube'     => 'nullable|string|max:200',
            'school_maps_url'    => 'nullable|string|max:1000',
            'school_logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'stat_eleves'        => 'nullable|string|max:20',
            'stat_enseignants'   => 'nullable|string|max:20',
            'stat_experience'    => 'nullable|string|max:20',
            'stat_reussite'      => 'nullable|string|max:20',
            'flash_infos'        => 'nullable|string',
            'espace_parent_url'  => 'nullable|string|max:200',
        ]);

        // Upload logo
        $logoPath = $this->readEnvValue('SCHOOL_LOGO');

        if ($request->hasFile('school_logo')) {
            $uploadDir = public_path('storage/uploads/settings');
            File::ensureDirectoryExists($uploadDir);

            if ($logoPath) {
                $oldFile = public_path('storage/' . $logoPath);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file      = $request->file('school_logo');
            $fileName  = \Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);

            $logoPath = 'uploads/settings/' . $fileName;
        }

        // Mise à jour des variables
        $envData = [
            'SCHOOL_NAME'              => $data['school_name'],
            'SCHOOL_SLOGAN'            => $data['school_slogan']      ?? '',
            'SCHOOL_DESC'              => $data['school_description'] ?? '',
            'SCHOOL_ADDRESS'           => $data['school_address']     ?? '',
            'SCHOOL_PHONE'             => $data['school_phone']       ?? '',
            'SCHOOL_PHONE2'            => $data['school_phone2']      ?? '',
            'SCHOOL_EMAIL'             => $data['school_email']       ?? '',
            'SCHOOL_WEBSITE'           => $data['school_website']     ?? '',
            'SCHOOL_HOURS'             => $data['school_hours']       ?? '',
            'SCHOOL_FACEBOOK'          => $data['school_facebook']    ?? '',
            'SCHOOL_INSTAGRAM'         => $data['school_instagram']   ?? '',
            'SCHOOL_TWITTER'           => $data['school_twitter']     ?? '',
            'SCHOOL_LINKEDIN'          => $data['school_linkedin']    ?? '',
            'SCHOOL_YOUTUBE'           => $data['school_youtube']     ?? '',
            'SCHOOL_MAPS_URL'          => $data['school_maps_url']    ?? '',
            'SCHOOL_LOGO'              => $logoPath                   ?? '',
            'SCHOOL_STAT_ELEVES'       => $data['stat_eleves']        ?? '',
            'SCHOOL_STAT_ENSEIGNANTS'  => $data['stat_enseignants']   ?? '',
            'SCHOOL_STAT_EXPERIENCE'   => $data['stat_experience']    ?? '',
            'SCHOOL_STAT_REUSSITE'     => $data['stat_reussite']      ?? '',
            'SCHOOL_ESPACE_PARENT_URL' => $data['espace_parent_url']  ?? '',
        ];

        $this->updateEnv($envData);

        // Flash infos → fichier JSON
        if (isset($data['flash_infos'])) {
            $infos = array_values(array_filter(
                array_map('trim', explode("\n", $data['flash_infos']))
            ));
            $jsonDir = public_path('storage/settings');
            File::ensureDirectoryExists($jsonDir);
            File::put($jsonDir . '/flash_infos.json',
                json_encode($infos, JSON_UNESCAPED_UNICODE)
            );
        }

        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');

        return redirect()->route('admin.parametres.index')
            ->with('success', 'Paramètres mis à jour avec succès !');
    }

    private function getEnvPath(): string
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            file_put_contents($envPath, '');
        }
        return $envPath;
    }

    private function readEnvValue(string $key): ?string
    {
        $envPath = $this->getEnvPath();
        $content = file_get_contents($envPath);
        if (preg_match("/^{$key}=(.*)$/m", $content, $matches)) {
            return trim($matches[1], '"\'') ?: null;
        }
        return env($key) ?: null;
    }

    private function updateEnv(array $data): void
    {
        $envPath    = $this->getEnvPath();
        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $value = str_replace('"', '\\"', $value);
            if (str_contains($value, ' ') || str_contains($value, '#')) {
                $value = '"' . $value . '"';
            }

            if (preg_match("/^{$key}=.*/m", $envContent)) {
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $envContent
                );
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);
    }
}