import { makeid } from "utils/helper";
import useAjax from "hook/useApi";
import React from "react";


export default function FileDragDrop({ fileOrigin, path, onLoadFiles, onProcesingFile, upLoadFileSuccess, uploadFileError }) {

    const ajax = useAjax();

    const uploadFiles = (key, index) => {


        if (!window.__fileManagerChunkFile[key]) {
            return false;
        }


        let file = window.__fileManagerChunkFile[key].file;

        const urlPrefix = process.env.REACT_APP_BASE_URL + 'api/admin/';

        let xhr = new XMLHttpRequest();
        // xhr.setRequestHeader('Accept', 'application/json');
        // xhr.setRequestHeader('Content-Type', 'application/json');
        // xhr.setRequestHeader('Origin', '*');

        xhr.upload.addEventListener("progress", (e) => {
            onProcesingFile(file, ((window.__fileManagerChunkFile[key].loaded + e.loaded) / window.__fileManagerChunkFile[key].size * 100).toFixed(1));
        }, false);

        xhr.upload.addEventListener("load", (e) => {
            let percent = ((window.__fileManagerChunkFile[key].loaded + e.loaded) / window.__fileManagerChunkFile[key].size * 100).toFixed(1);

            if (Number(percent) >= 100) {
                percent = '100';
            }

            onProcesingFile(file, percent);
        }, false);

        xhr.onreadystatechange = function () {

            if (xhr.readyState == 4) {

                if (xhr.status == 200) {

                    let result = JSON.parse(xhr.responseText);

                    if (result.message) {
                        ajax.showNotification(result.message);
                    }

                    if (result.require_login) {
                        ajax.requestLogin('file-manager/upload', {
                            callback: uploadFiles,
                            params: file
                        });
                    }

                    if (result.success) {

                        if (index === 0) {
                            window.__fileManagerChunkFile[key].chunkName = result.chunkName;
                        }

                        if (index < window.__fileManagerChunkFile[key].chunks.length) {
                            uploadFiles(key, index + 1);
                            window.__fileManagerChunkFile[key].loaded += window.__fileManagerChunkFile[key].chunks[index].size;
                        } else {
                            upLoadFileSuccess(file);
                        }
                    }

                } else {
                    if (xhr.statusText) {
                        uploadFileError(file, xhr.statusText);
                    }
                }
            }
        };

        let formdata = new FormData();

        if (window.__fileManagerChunkFile[key].chunks[index]) {
            formdata.append('file', window.__fileManagerChunkFile[key].chunks[index]);
        }

        formdata.append('path', path);
        formdata.append('name', window.__fileManagerChunkFile[key].name);
        formdata.append('size', window.__fileManagerChunkFile[key].size);
        formdata.append('chunkName', window.__fileManagerChunkFile[key].chunkName);
        formdata.append('chunk', index + '');
        formdata.append('chunks', window.__fileManagerChunkFile[key].chunks.length);

        xhr.open('POST', urlPrefix + 'file-manager/upload');

        xhr.onerror = (e) => {
            ajax.showNotification('Error');
        };
        xhr.onabort = (e) => {
            console.log(xhr);
        };

        xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('access_token'));
        xhr.send(formdata);
        // xhr.abort();
    }

    const handleOnDrop = (ev) => {
        // Prevent default behavior (Prevent file from being opened)
        ev.preventDefault();
        ev.stopPropagation();

        let files = [];
        let procesingNew = {};

        var imageTypes = ['image/png', 'image/gif', 'image/bmp', 'image/jpg', 'image/jpeg'];

        if (window.__filesUpload) {
            window.__filesUpload = [];
        }

        for (let i = 0; i < ev.dataTransfer.files.length; i++) {

            let fileType = ev.dataTransfer.files[i].type;

            //@ts-ignore
            ev.dataTransfer.files[i].is_image = imageTypes.includes(fileType);
            //@ts-ignore
            ev.dataTransfer.files[i].key = makeid(10, 'file_manage');

            //@ts-ignore
            ev.dataTransfer.files[i].chunks = [];

            var Blob = ev.dataTransfer.files[i];
            const BYTES_PER_CHUNK = 2097152; //2MB
            const SIZE = Blob.size;
            var Start = 0;
            var End = BYTES_PER_CHUNK;

            if (!window.__fileManagerChunkFile) {
                window.__fileManagerChunkFile = {};
            }
            //@ts-ignore
            window.__fileManagerChunkFile[ev.dataTransfer.files[i].key] = {};
            //@ts-ignore
            window.__fileManagerChunkFile[ev.dataTransfer.files[i].key].file = ev.dataTransfer.files[i];
            //@ts-ignore
            window.__fileManagerChunkFile[ev.dataTransfer.files[i].key].name = ev.dataTransfer.files[i].name;
            //@ts-ignore
            window.__fileManagerChunkFile[ev.dataTransfer.files[i].key].size = SIZE;
            //@ts-ignore
            window.__fileManagerChunkFile[ev.dataTransfer.files[i].key].chunk = 0;
            //@ts-ignore
            window.__fileManagerChunkFile[ev.dataTransfer.files[i].key].loaded = 0;
            //@ts-ignore
            window.__fileManagerChunkFile[ev.dataTransfer.files[i].key].chunks = [];
            console.log(ev.dataTransfer.files[i]);
            while (Start < SIZE) {
                var Chunk = Blob.slice(Start, End);
                //@ts-ignore
                window.__fileManagerChunkFile[ev.dataTransfer.files[i].key].chunks.push(Chunk);
                Start = End;
                End = Start + BYTES_PER_CHUNK;
            }


            //@ts-ignore
            uploadFiles(ev.dataTransfer.files[i].key, 0);

            files.push(ev.dataTransfer.files[i]);
            //@ts-ignore
            procesingNew[ev.dataTransfer.files[i].name] = 0;
        }

        if (onLoadFiles) {
            onLoadFiles(files)
        }

        //@ts-ignore
        ev.currentTarget.style.bordeSize = '1px';
        //@ts-ignore
        ev.currentTarget.style.borderColor = null;
        //@ts-ignore
        ev.currentTarget.style.backgroundColor = null;
    }

    const handelOnDragOver = (ev) => {
        //@ts-ignore
        ev.currentTarget.style.bordeSize = '1px';
        //@ts-ignore
        ev.currentTarget.style.borderColor = '#2196f3';
        //@ts-ignore
        ev.currentTarget.style.backgroundColor = '#e3f2fd';
        // Prevent default behavior (Prevent file from being opened)
        ev.preventDefault();
        ev.stopPropagation();
    }

    const handelOnDragLeave = (ev) => {
        //@ts-ignore
        ev.currentTarget.style.borderColor = null;
        //@ts-ignore
        ev.currentTarget.style.backgroundColor = null;
        //@ts-ignore
        ev.currentTarget.style.transition = 'all 0.08s';
        ev.preventDefault();
        ev.stopPropagation();
    }

    if (!fileOrigin || fileOrigin.is_dir) {
        return {
            onDrop: handleOnDrop,
            onDragOver: handelOnDragOver,
            onDragLeave: handelOnDragLeave,
        };
    }
    return {};
}

