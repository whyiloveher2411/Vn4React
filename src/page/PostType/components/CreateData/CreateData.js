import { LinearProgress } from '@material-ui/core';
import { AddOn, Hook, Page, TabsCustom } from 'components';
import React, { useState } from 'react';
import { toCamelCase } from 'utils/helper';
import { getUrlParams } from 'utils/herlperUrl';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import Form from './Form';
import Header from './Header';

const CreateData = (props) => {

    const { match, history, location } = props;

    const [data, setData] = useState(false);

    const { ajax, open } = useAjax();

    const [title, setTitle] = useState('...');

    let id = getUrlParams(window.location.search, 'post_id');

    const { callAddOn } = AddOn();

    const onReview = (value) => {
        setData((prev) => ({ ...prev, post: { ...value } }));
    }

    const handleSubmit = () => {

        if (!open) {
            ajax({
                url: 'post-type/post/' + match.params.type,
                method: 'POST',
                data: { ...data.post, _action: data.action },
                isGetData: false,
                success: (result) => {

                    if (result.post) {
                        if (result.post.id !== data.post.id) {
                            history.push(`/post-type/${match.params.type}/list?redirectTo=edit&post=${result.post.id}`);
                            return;
                        } else {
                            result.updatePost = new Date();
                            setData({ ...data, post: result.post, author: result.author, editor: result.editor, updatePost: new Date() })
                        }
                    }

                }
            });
        }

    };

    React.useEffect(() => {

        ajax({
            url: `post-type/detail/${match.params.type}/${id}`,
            method: 'POST',
            success: function (result, showNotification) {

                if (result.redirect) {

                    history.push(result.redirect);
                    return;

                } else {

                    if (result.config) {

                        result.type = match.params.type;
                        result.updatePost = new Date();

                        if (result.post) {

                            setTitle(__('Edit') + ' "' + result.post[Object.keys(result.config.fields)[0]] + '"');
                            result.action = 'EDIT';

                        } else {

                            if (match.params.action === 'edit') {
                                history.push(`/post-type/${match.params.type}/list`);
                                showNotification(__('Does not exist {{post_type}} with id is {{id}}', {
                                    post_type: result.config.title,
                                    id
                                }), 'warning');
                                return;
                            } else {
                                setTitle(__('Add new') + ' ' + result.config?.title);
                                result.action = 'ADD_NEW';
                                result = { ...result, post: { meta: {} } };
                            }
                        }

                        result.config.extendedTab = callAddOn(
                            'CreateData/Tabs',
                            match.params.type,
                            { formEdit: { title: __('Edit'), priority: 1 } },
                            { ...result }
                        );

                        setData({ ...result });

                    }

                }
            }
        });
    }, [location]);

    return (
        <>
            <Hook
                hook={'PostType/' + toCamelCase(match.params.type) + '/CreateData'}
                {...props}
                data={data}
                postType={match.params.type}
                onReview={onReview} />
            {!data &&
                <LinearProgress style={{ position: 'absolute', left: 0, right: 0 }} />
            }
            {
                (() => {

                    try {

                        let component = toCamelCase(match.params.type);
                        let resolved = require(`../../CustomPostType/${component}`).default;

                        if (data) {
                            return React.createElement(resolved, { ...props, data: data });
                        }

                        return <></>;
                    } catch (error) {

                        return (
                            <Page title={title}>
                                {/* {Loading} */}
                                {data &&
                                    <>
                                        <Header
                                            postType={match.params.type}
                                            data={data}
                                            title={title}
                                            showLoadingButton={open}
                                            handleSubmit={handleSubmit}
                                            goBack={true}
                                            backToList={true}
                                        />
                                        <br />
                                        {
                                            Boolean(Object.keys(data.config.extendedTab).length > 1)
                                                ?
                                                <TabsCustom
                                                    name={'create_data_extendedTab_' + match.params.type}
                                                    tabs={
                                                        (() => {
                                                            let result = Object.keys(data.config.extendedTab).map(key => {

                                                                if (key === 'formEdit') {
                                                                    return {
                                                                        ...data.config.extendedTab[key],
                                                                        title: data.config.extendedTab[key].title ?? __('Edit'),
                                                                        content: () => <Form
                                                                            {...props}
                                                                            data={data}
                                                                            postType={match.params.type}
                                                                            onReview={onReview}
                                                                        />
                                                                    }
                                                                }

                                                                if (data.config.extendedTab[key].content) {
                                                                    return {
                                                                        ...data.config.extendedTab[key],
                                                                        content: () => <Hook
                                                                            hook={data.config.extendedTab[key].content} {...props}
                                                                            data={data}
                                                                            postType={match.params.type}
                                                                            onReview={onReview} />
                                                                    }
                                                                }

                                                                if (data.config.extendedTab[key].component) {
                                                                    return {
                                                                        ...data.config.extendedTab[key],
                                                                        content: () => data.config.extendedTab[key].component({
                                                                            ...props,
                                                                            data: data,
                                                                            postType: match.params.type,
                                                                            onReview: onReview
                                                                        })
                                                                    }
                                                                }
                                                            });
                                                            return result;
                                                        })()
                                                    }
                                                />
                                                :
                                                <Form
                                                    {...props}
                                                    data={data}
                                                    postType={match.params.type}
                                                    onReview={onReview}
                                                />
                                        }
                                    </>
                                }
                            </Page>
                        );
                    }

                })()

            }
        </>
    )
}

export default CreateData
