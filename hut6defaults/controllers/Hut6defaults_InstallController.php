<?php
namespace Craft;

class Seo_InstallController extends BaseController
{
    protected $allowAnonymous = true;

    public function actionGroup()
    {
        $group = new FieldGroupModel();
        $group->id = null;
        $group->name = "SEO";

        $isNewGroup = empty($group->id);

        $source = new AssetSourceModel();

        $source->handle = "Images";
        $source->name = "images";
        $source->type = "Local";

        $source->settings = array(
            "path" => "{assetsImagesPath}/",
            "url" => "{assetsImagesUrl}/"
        );

        $typeSettings = craft()->request->getPost('types');
        if (isset($typeSettings[$source->type])) {
            if (!$source->settings) {
                $source->settings = array();
            }

            $source->settings = array_merge($source->settings, $typeSettings[$source->type]);
        }

        $fieldLayout = craft()->fields->assembleLayoutFromPost(false);
        $fieldLayout->type = ElementType::Asset;
        $source->setFieldLayout($fieldLayout);

        if (craft()->assetSources->saveSource($source)) {
            craft()->userSession->setNotice(Craft::t('Source saved.'));

            if (craft()->fields->saveGroup($group)) {
                if ($isNewGroup) {
                    craft()->userSession->setNotice(Craft::t('Group added.'));
                }

                $group_id = $group->getAttributes()["id"];

                $fieldTitle = new FieldModel();
                $fieldTitle->id = null;
                $fieldTitle->groupId = $group_id;
                $fieldTitle->name = "SEO Title";
                $fieldTitle->handle = "seoTitle";
                $fieldTitle->instructions = "";
                $fieldTitle->translatable = true;
                $fieldTitle->type = "PlainText";

                $fieldDescription = new FieldModel();
                $fieldDescription->id = null;
                $fieldDescription->groupId = $group_id;
                $fieldDescription->name = "Seo Description";
                $fieldDescription->handle = "seoDescription";
                $fieldDescription->instructions = "";
                $fieldDescription->translatable = true;
                $fieldDescription->type = "PlainText";

                $fieldImage = new FieldModel();
                $fieldImage->id = null;
                $fieldImage->groupId = $group_id;
                $fieldImage->name = "Seo Image";
                $fieldImage->handle = "seoImage";
                $fieldImage->instructions = "";
                $fieldImage->translatable = true;
                $fieldImage->type = "Assets";

                $fieldImage->settings = array(
                    "useSingleFolder" => "",
                    "sources" => "*",
                    "defaultUploadLocationSource" =>  $source->id,
                    "defaultUploadLocationSubpath" => "",
                    "singleUploadLocationSource" =>  $source->id,
                    "singleUploadLocationSubpath" => "",
                    "restrictFiles" => "1",
                    "allowedKinds" => ["image"],
                    "limit" => ""
                );

                craft()->fields->saveField($fieldTitle) ? null : $this->returnJson(['errors' => $group->getErrors()]);
                craft()->fields->saveField($fieldDescription) ? null : $this->returnJson(['errors' => $group->getErrors()]);
                craft()->fields->saveField($fieldImage) ? null : $this->returnJson(['errors' => $group->getErrors()]);

                $this->returnJson(array(
                    'success' => true
                ));
            } else {
                $this->returnJson(array(
                    'errors' => $group->getErrors(),
                ));
            }
        } else {
            craft()->userSession->setError(Craft::t('Couldn’t save source.'));
            $this->returnJson(array(
                'errors' => $source->getErrors(),
            ));
        }

        $this->returnJson(array(
            'success' => false
        ));
    }

}