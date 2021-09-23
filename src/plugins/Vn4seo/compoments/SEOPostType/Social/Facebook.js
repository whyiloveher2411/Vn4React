import React from 'react'
import FieldForm from 'components/FieldForm';

function Facebook({ data, onReview }) {

    const [render, setRender] = React.useState(0);

    return (
        <div>
            <div style={{ margin: '24px 0' }}>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Title'
                    }}
                    post={data}
                    name='plugin_vn4seo_facebook_title'
                    onReview={(value) => { onReview('plugin_vn4seo_facebook_title', value); setRender(render + 1); }}
                />
            </div>
            <div style={{ margin: '24px 0' }}>
                <FieldForm
                    compoment='textarea'
                    config={{
                        title: 'Description'
                    }}
                    post={data}
                    name='plugin_vn4seo_facebook_description'
                    onReview={(value) => { onReview('plugin_vn4seo_facebook_description', value); setRender(render + 1); }}
                />
            </div>
            <div style={{ margin: '24px 0' }}>
                <FieldForm
                    compoment='image'
                    config={{
                        title: 'Image'
                    }}
                    post={data}
                    name='plugin_vn4seo_facebook_image'
                    onReview={(value) => { onReview('plugin_vn4seo_facebook_image', value); setRender(render + 1); }}
                />
            </div>
        </div>
    )
}

export default Facebook
