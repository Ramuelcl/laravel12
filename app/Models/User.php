<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage; // Importa la clase Storage
use Illuminate\Support\Str;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'is_active'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];


  /**
   * The accessors to append to the model's array form.
   *
   * @var array<int, string>
   */
  protected $appends = [
    'profile_photo_url',
  ];

  /**
   * Accessor para obtener la URL de la foto de perfil.
   *
   * @return Attribute
   */
  protected function profilePhotoUrl(): Attribute {
    return Attribute::make(
      get: fn() => $this->profile_photo_path
        ? Storage::url($this->profile_photo_path)
        : 'https://ui-avatars.com/api/?name=' . urlencode($this->name),
    );
  }
  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
      'is_active' => 'boolean',
    ];
  }

  /**
   * Get the user's initials
   */
  public function initials(): string
  {
    return Str::of($this->name)
      ->explode(' ')
      ->map(fn(string $name) => Str::of($name)->substr(0, 1))
      ->implode('');
  }
}
