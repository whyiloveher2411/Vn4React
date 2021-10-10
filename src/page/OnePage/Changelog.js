import { Typography } from '@material-ui/core'
import { makeStyles } from '@material-ui/styles'
import Markdown from 'components/Markdown'
import { PageHeaderSticky } from 'components/Page'
import React, { useEffect, useState } from 'react'
import { __ } from 'utils/i18n'

const Changelog = () => {

    const [source, setSource] = useState('')

    useEffect(() => {
        fetch('/docs/Changelog.md')
            .then((response) => response.text())
            .then((text) => setSource(text))
    }, [])

    return (
        <PageHeaderSticky
            title={__('Changelog')}
            header={
                <>
                    <Typography gutterBottom variant="overline">
                        {__('Support')}
                    </Typography>
                    <Typography variant="h3">{__('Changelog')}</Typography>
                </>
            }
        >
            {source && (
                <Markdown
                    escapeHtml={false}
                    source={source} //
                />
            )}
        </PageHeaderSticky>
    )
}

export default Changelog
