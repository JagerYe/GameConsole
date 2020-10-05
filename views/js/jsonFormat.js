function organizeFormat(jsonStr) {
    if (jsonStr.substr(0, 1) !== "{") {
        jsonStr = jsonStr.substr(jsonStr.lastIndexOf("{"), jsonStr.lastIndexOf("}"));
    }
    return jsonStr;
}