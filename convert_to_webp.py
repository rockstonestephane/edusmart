from PIL import Image
import os
import sys
from pathlib import Path

def convert_to_webp(folder_path=".", quality=85, delete_originals=False):
    """
    Convertit tous les PNG et JPG d'un dossier en WebP.
    
    Args:
        folder_path: Chemin du dossier contenant les images
        quality: Qualité WebP (1-100), 85 est un bon équilibre qualité/poids
        delete_originals: Supprimer les fichiers originaux après conversion
    """
    folder = Path(folder_path)
    extensions = (".png", ".jpg", ".jpeg", ".PNG", ".JPG", ".JPEG")
    images = [f for f in folder.rglob("*") if f.suffix in extensions]

    if not images:
        print("Aucune image PNG/JPG trouvée.")
        return

    print(f"🔍 {len(images)} image(s) trouvée(s)\n")
    total_original = 0
    total_converted = 0

    for img_path in images:
        try:
            original_size = img_path.stat().st_size
            total_original += original_size

            with Image.open(img_path) as img:
                # Conserver la transparence pour les PNG
                if img_path.suffix.lower() == ".png" and img.mode in ("RGBA", "LA"):
                    img = img.convert("RGBA")
                else:
                    img = img.convert("RGB")

                webp_path = img_path.with_suffix(".webp")
                img.save(webp_path, "WEBP", quality=quality, method=6)

            converted_size = webp_path.stat().st_size
            total_converted += converted_size
            reduction = (1 - converted_size / original_size) * 100

            print(f"✅ {img_path.name} → {webp_path.name} "
                  f"({original_size//1024} Ko → {converted_size//1024} Ko, -{reduction:.0f}%)")

            if delete_originals:
                img_path.unlink()
                print(f"   🗑️  Original supprimé")

        except Exception as e:
            print(f"❌ Erreur sur {img_path.name} : {e}")

    # Résumé
    total_reduction = (1 - total_converted / total_original) * 100 if total_original > 0 else 0
    print(f"\n📊 Résumé :")
    print(f"   Avant  : {total_original / 1024:.0f} Ko")
    print(f"   Après  : {total_converted / 1024:.0f} Ko")
    print(f"   Gain   : -{total_reduction:.0f}% 🎉")


if __name__ == "__main__":
    # Utilisation : python convert_to_webp.py [dossier] [qualité] [supprimer_originaux]
    folder = sys.argv[1] if len(sys.argv) > 1 else "."
    quality = int(sys.argv[2]) if len(sys.argv) > 2 else 85
    delete = sys.argv[3].lower() == "true" if len(sys.argv) > 3 else False

    convert_to_webp(folder, quality, delete)
