<?php

namespace App\Commands\User;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\User\IUserSetAvatarCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IUser;
use App\Exceptions\CommandException;
use App\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserSetAvatarCommand extends ACommand implements IUserSetAvatarCommand
{
    /** @var IUser $user */
    private $user;

    /** @var UploadedFile $file */
    private $file;

    public function __construct(IUser $user, UploadedFile $file)
    {
        $this->user = $user;
        $this->file = $file;
    }

    /**
     * @return IUser
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->user;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
            $fileName = str_random(16) . '.' . $this->file->extension();
            $image = Image::make($this->file)->fit(300)->save($storagePath . $fileName);
            $file = File::create(['path' => $image->basename, 'original_name' => $image->basename]);

            $this->user->avatar_file_id = $file->id;
            $this->user->save();
        } catch (\Exception $e){
            throw new CommandException($e->getMessage());
        }

        $this->executed = true;
    }

}