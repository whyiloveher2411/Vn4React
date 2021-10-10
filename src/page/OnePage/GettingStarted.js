import { Typography } from '@material-ui/core'
import { makeStyles } from '@material-ui/styles'
import { Markdown } from 'components'
import { PageHeaderSticky } from 'components/Page'
import React, { useEffect, useState } from 'react'
import { __ } from 'utils/i18n'

const GettingStarted = () => {

    const [source, setSource] = useState('')

    useEffect(() => {
        fetch('/docs/GettingStarted.md')
            .then((response) => response.text())
            .then((text) => setSource(text))
    }, [])

    return (
        <PageHeaderSticky
            title={__('Getting Started')}
            header={
                <>
                    <Typography gutterBottom variant="overline">
                        {__('Development')}
                    </Typography>
                    <Typography variant="h3">{__('Getting Started')}</Typography>
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

export default GettingStarted
