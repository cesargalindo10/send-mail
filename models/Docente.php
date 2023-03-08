<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docente".
 *
 * @property int $id_docente
 * @property string $nombre
 * @property string $correo
 */
class Docente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'correo'], 'required'],
            [['nombre', 'correo'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_docente' => 'Id Docente',
            'nombre' => 'Nombre',
            'correo' => 'Correo',
        ];
    }
}
