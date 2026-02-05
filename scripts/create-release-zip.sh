#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIST_DIR="$ROOT_DIR/dist"
STAMP="$(date +%Y%m%d-%H%M%S)"
ZIP_NAME="gks-mini-cms-${STAMP}.zip"
ZIP_PATH="$DIST_DIR/$ZIP_NAME"

mkdir -p "$DIST_DIR"

cd "$ROOT_DIR"
zip -r "$ZIP_PATH" \
  admin \
  config \
  includes \
  public \
  sql \
  uploads \
  README.md \
  .gitignore \
  -x "*.git*" "dist/*"

echo "ZIP erstellt: $ZIP_PATH"
