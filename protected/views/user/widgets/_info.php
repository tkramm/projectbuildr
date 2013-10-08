<h4>Info</h4>

    <table>
        <tr>
            <td>Registred:</td>
            <td colspan="2"><?php echo CHtml::encode($model->created); ?></td>
        </tr>
        <tr>
            <td style="padding-right: 10px;">Last Update:</td>
            <td colspan="2"><?php echo CHtml::encode($model->updated); ?></td>
        </tr>
        <tr>
            <td>Projects:</td>
            <td colspan="2"><?php echo count($model->projects); ?></td>
        </tr>
        <tr>
            <td>Parts created:</td>
            <td colspan="2"><?php echo count($model->createdParts); ?></td>
        </tr>
    </table>