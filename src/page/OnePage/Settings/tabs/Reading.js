import React from 'react'
import { __ } from 'utils/i18n';
import ReadingSetting from '../components/ReadingSetting';

function Reading({ post, data, onReview }) {
    return (
        <div>
            <ReadingSetting
                compoment={'radio'}
                config={{
                    title: __('Homepage'),
                    readingPageStatic: data.reading_page_static,
                    adminObject: data.admin_object
                }}
                post={post}
                name={'reading_homepage'}
                onReview={value => onReview(value, 'reading_homepage')}
            />
        </div>
    )
}

export default Reading
