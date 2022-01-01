import { Typography } from '@material-ui/core';
import { Page } from 'components';
import GoogleDrive from 'components/FieldForm/image/GoogleDrive';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { __ } from 'utils/i18n';
import { usePermission } from 'utils/user';

function Media() {

    const permission = usePermission('media_management');

    const filesActive = React.useState({});

    if (!permission.media_management) {
        return <RedirectWithMessage />
    }
    return (
        <Page width="xl" title="Appearance">
            <div>
                <Typography component="h2" gutterBottom variant="overline">{__('Management')}</Typography>
                <Typography component="h1" variant="h3">{__('Media Library')}</Typography>
            </div>
            <br />
            <GoogleDrive filesActive={filesActive} fileType={['ext_file', 'ext_image', 'ext_misc', 'ext_video', 'ext_music']} handleChooseFile={() => { }} config={{}} />
        </Page>
    )
}

export default Media
