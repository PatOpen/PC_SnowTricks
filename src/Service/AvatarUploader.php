<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvatarUploader
{
	private string $avatarDirectory;

	public function __construct( string $avatarDirectory)
	{
		$this->avatarDirectory = $avatarDirectory;
	}

	/**
	 * @param UploadedFile $file
	 *
	 * @return string
	 */
	public function upload( UploadedFile $file ): string
	{
		$originalFilename = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
		$safeFilename     = transliterator_transliterate( 'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename );
		$fileName         = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

		try
		{
			$file->move( $this->getTargetDirectory(), $fileName );
		} catch ( FileException $e )
		{

		}

		return $fileName;
	}

	/**
	 * @return string
	 */
	public function getTargetDirectory(): string
	{
		return $this->avatarDirectory;
	}
}