import { AddOn, Hook, Page, TabsCustom } from 'components'
import React, { useEffect, useState } from 'react'
import { Redirect } from 'react-router-dom'
import { toCamelCase } from 'utils/helper'
import { getUrlParams, replaceUrlParam } from 'utils/herlperUrl'
import { useAjax } from 'utils/useAjax'
import Header from './Header'
import Results from './Results'
import SearchBar from './SearchBar'


const ShowData = (props) => {

    const { match, history } = props;

    const [data, setData] = useState([]);
    const [title, setTitle] = useState('...');

    const [showLoading, setShowLoading] = useState(true);
    const [isLoadedData, setIsLoadedData] = useState(false);
    const [render, setRender] = useState(0);

    const { callAddOn } = AddOn();

    const { ajax } = useAjax();

    const valueInital = {
        rowsPerPage: 10,
        page: 1,
        search: '',
        filter: 'all',
        ...getUrlParams(window.location.search)
    };

    const [queryUrl, setQueryUrl] = useState(valueInital);

    useEffect(() => {
        setQueryUrl({ ...valueInital, ...getUrlParams(window.location.search) });
    }, [match]);

    const ajaxHandle = (params) => {

        setShowLoading(true);

        ajax({
            url: `post-type/${params.url}`,
            method: 'POST',
            data: params.data,
            success: (result) => {

                if (params.success) {
                    params.success(result);
                }

            },
            finally: () => {
                setShowLoading(false);

                if (params.finally) {
                    params.finally();
                }
            }
        });

    };

    useEffect(() => {

        if (!render) {
            setRender(render + 1);
            return;
        }

        let mounted = true

        ajaxHandle({
            url: `get-data/${match.params.type}`,
            method: 'POST',
            data: queryUrl,
            success: function (result) {

                if (result.redirect) {
                    history.push(result.redirect);
                } else {

                    if (result.config && mounted) {
                        result.type = match.params.type;

                        result.config.extendedTab = callAddOn('ShowData/Tabs', match.params.type, { list: { title: 'List', priority: 1 } });

                        setData(result);
                        setTitle(result.config?.title);
                        setIsLoadedData(true);
                        let url = replaceUrlParam(window.location.href, queryUrl);
                        window.history.pushState({ url: url, page: 'Page template table' }, "Page template table", url);

                    }
                }
            }
        });

        return () => {
            mounted = false
        }

    }, [queryUrl]);

    const acctionPost = (payload, success) => {
        ajaxHandle({
            url: `get-data/${match.params.type}`,
            method: 'POST',
            data: {
                ...queryUrl,
                ...payload,
            },
            success: function (result) {
                if (result.config) {
                    result.config.extendedTab = callAddOn('ShowData/Tabs', match.params.type, { list: { title: 'List', priority: 1 } });
                    setData(prev => ({ ...prev, ...result }));
                }
                if (success) {
                    success(result);
                }
            }
        });
    };

    const handleFilter = () => { }
    const handleSearch = (value) => {
        setQueryUrl({
            ...queryUrl,
            search: value
        });
    }

    const redirectTo = getUrlParams(window.location.search, 'redirectTo');

    if (redirectTo === 'edit') {
        return <Redirect to={`/post-type/${match.params.type}/edit?post_id=` + getUrlParams(window.location.search, 'post')} />
    }

    return (
        <>
            <Hook
                hook={'ShowData' + toCamelCase(match.params.type)}
                result={data}
                loading={showLoading}
                queryUrl={queryUrl}
                setQueryUrl={setQueryUrl}
                isLoadedData={isLoadedData}
                history={props.history}
                postType={match.params.type}
                acctionPost={acctionPost}
                onFilter={handleFilter} />
            <Page title={title}>
                <Header type={match.params.type} label={data.config?.label} />
                <br />

                {
                    Boolean(data && data.config && data.config.extendedTab && Object.keys(data.config.extendedTab).length > 1)
                        ?
                        <TabsCustom
                            name={'show_data_' + match.params.type}
                            tabs={
                                (() => {
                                    let result = Object.keys(data.config.extendedTab).map(key => {

                                        if (key === 'list') {
                                            return {
                                                ...data.config.extendedTab[key],
                                                title: data.config.extendedTab[key].title ?? 'List',
                                                content: () => <>
                                                    <SearchBar onValue={queryUrl.search} onSearch={handleSearch} />
                                                    {data && (
                                                        <Results
                                                            result={data}
                                                            loading={showLoading}
                                                            queryUrl={queryUrl}
                                                            setQueryUrl={setQueryUrl}
                                                            isLoadedData={isLoadedData}
                                                            history={props.history}
                                                            postType={match.params.type}
                                                            acctionPost={acctionPost}
                                                            onFilter={handleFilter}
                                                        />
                                                    )}
                                                </>
                                            }
                                        }

                                        if (data.config.extendedTab[key].content) {
                                            return {
                                                ...data.config.extendedTab[key],
                                                content: () => <Hook
                                                    hook={data.config.extendedTab[key].content} {...props}
                                                    result={data}
                                                    loading={showLoading}
                                                    queryUrl={queryUrl}
                                                    setQueryUrl={setQueryUrl}
                                                    isLoadedData={isLoadedData}
                                                    history={props.history}
                                                    postType={match.params.type}
                                                    acctionPost={acctionPost}
                                                    onFilter={handleFilter}
                                                />
                                            }
                                        }

                                        if (data.config.extendedTab[key].component) {
                                            return {
                                                ...data.config.extendedTab[key],
                                                content: () => data.config.extendedTab[key].component({
                                                    result: data,
                                                    loading: showLoading,
                                                    queryUrl: queryUrl,
                                                    setQueryUrl: setQueryUrl,
                                                    isLoadedData: isLoadedData,
                                                    history: props.history,
                                                    postType: match.params.type,
                                                    acctionPost: acctionPost,
                                                    onFilter: handleFilter
                                                })
                                            }
                                        }
                                    });
                                    return result;
                                })()
                            }
                        />
                        :
                        <>
                            <SearchBar onValue={queryUrl.search} onSearch={handleSearch} />
                            {data && (
                                <Results
                                    result={data}
                                    loading={showLoading}
                                    queryUrl={queryUrl}
                                    setQueryUrl={setQueryUrl}
                                    isLoadedData={isLoadedData}
                                    history={props.history}
                                    postType={match.params.type}
                                    acctionPost={acctionPost}
                                    onFilter={handleFilter}
                                />
                            )}
                        </>
                }
            </Page>
        </>
    )
}

export default ShowData
