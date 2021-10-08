import { Typography } from '@material-ui/core'
import GoogleDrive from 'components/FieldForm/image/GoogleDrive';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react'
import { __ } from 'utils/i18n';
import { checkPermission } from 'utils/user';
import { Page } from 'components'

function Media() {

    const permission = checkPermission('media_management');

    const filesActive = React.useState({});

    if (!permission) {
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
