"use strict";
import axios from 'axios';

export const loginBackpanel = () => {
    return axios.get("/admin-backpanel");
}

// App Releases
export const getReleaseEntries = () => {
    return axios.get("/get-app-release-details");
}

export const createReleaseEntry = (entry) => {
    return axios.post("/create-app-release", {
        title: entry.title,
        description: entry.description,
        version: entry.version,
        type: entry.type
    });
}

export const updateReleaseEntry = (entry) => {
    return axios.post("/update-app-release", {
        id: entry.id,
        title: entry.title,
        description: entry.description,
        version: entry.version,
        type: entry.type
    });
}

export const deleteReleaseEntry = (entry) => {
    return axios.delete("/delete-app-release/" + entry.id);
}
