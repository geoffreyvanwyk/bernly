<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * Digits which make up base-62 numbers.
     *
     * @const string
     */
    const ALIAS_CHARACTER_SET = '0123456789'
                              . 'abcdefghijklmnopqrstuvwxyz'
                              . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Create an automatic alias for the link, that will be redirected to it.
     * The alias is a path that will be appended to the APP_SHORT_DOMAIN to
     * form a shorter URL.
     *
     * @return string
     */
    public function getAliasAttribute() : string
    {
        $alias = '';
        $base = strlen(self::ALIAS_CHARACTER_SET);
        $counter = $this->id;

        while ($counter > 0) {
            $alias = substr(self::ALIAS_CHARACTER_SET, ($counter % $base), 1) . $alias;
            $counter = floor($counter / $base);
        }

        return $alias;
    }

    /**
     * Find the id of the link with the given $alias.
     *
     * @param string $alias
     * @return \App\Link
     */
    public static function findFromAlias(string $alias) : Link
    {
        $id = 0;
        $base = strlen(self::ALIAS_CHARACTER_SET);
        $digits = str_split(strrev($alias));

        foreach ($digits as $place => $digit) {
            $id += strpos(self::ALIAS_CHARACTER_SET, $digit) * pow($base, $place);
        }

        return Link::findOrFail($id);
    }
}
