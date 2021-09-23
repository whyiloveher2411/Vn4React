import { Alert } from '@material-ui/lab';
import FieldForm from 'components/FieldForm';
import React from 'react';

function General({ data, onReview }) {

    const [render, setRender] = React.useState(0);

    return (
        <div>
            <div style={{ margin: ' 0 0 24px 0' }}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Title',
                        note: ' ',
                        maxLength: 70
                    }}
                    post={data}
                    name='plugin_vn4seo_google_title'
                    onReview={(value) => { onReview('plugin_vn4seo_google_title', value); setRender(render + 1); }}
                />
                <Alert icon={false} severity="info">You can submit titles with up to 150 characters, but because google only display up to 70 characters on Shopping ads and free product listings, we strongly encourage you to submit titles with 70 or less characters whenever possible.</Alert>

            </div>

            <div style={{ margin: '24px 0' }}>
                <FieldForm
                    compoment='textarea'
                    config={{
                        title: 'Description',
                        note: " ",
                        maxLength: '50–160'
                    }}
                    post={data}
                    name='plugin_vn4seo_google_description'
                    onReview={(value) => { onReview('plugin_vn4seo_google_description', value); setRender(render + 1); }}
                />
                <Alert icon={false} severity="info">Meta descriptions can be any length, but Google generally truncates snippets to ~155–160 characters. It's best to keep meta descriptions long enough that they're sufficiently descriptive, so we recommend descriptions between 50–160 characters. Keep in mind that the \"optimal\" length will vary depending on the situation, and your primary goal should be to provide value and drive clicks.</Alert>
            </div>

            <div>

                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Canonical URL',
                        note: "&nbsp;",
                    }}
                    post={data}
                    name='plugin_vn4seo_canonical_url'
                    onReview={(value) => { onReview('plugin_vn4seo_canonical_url', value); setRender(render + 1); }}
                />
                <Alert icon={false} severity="info">If you have a single page accessible by multiple URLs, or different pages with similar content (for example, a page with both a mobile and a desktop version), Google sees these as duplicate versions of the same page. Google will choose one URL as the canonical version and crawl that, and all other URLs will be considered duplicate URLs and crawled less often.</Alert>
            </div>

        </div>
    )
}

export default General
